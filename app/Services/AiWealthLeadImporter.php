<?php

namespace App\Services;

use App\Models\AiWealthInquiry;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class AiWealthLeadImporter
{
    public function import(UploadedFile $file): array
    {
        $rows = $this->readFile($file);
        if (count($rows) < 2) {
            throw new \RuntimeException('Excel file has no lead rows.');
        }

        return $this->importRows($rows, true, 'meta', 'meta-ads', true, true);
    }

    public function importRows(array $rows, bool $sendWhatsapp = true, string $source = 'meta', string $defaultPage = 'meta-ads', bool $forcePage = false, bool $replaceExisting = false): array
    {
        if (count($rows) < 2) {
            throw new \RuntimeException('No lead rows found.');
        }

        $headerRow = $this->findHeaderRow($rows);
        $headers = array_map(fn ($value) => $this->normalizeHeader((string) $value), $rows[$headerRow]);
        $dataRows = array_slice($rows, $headerRow + 1);
        $columns = $this->detectColumns($headers, $dataRows);

        if ($columns['mobile'] === null) {
            throw new \RuntimeException('Phone / mobile column not found.');
        }

        $existingMobiles = AiWealthInquiry::query()
            ->pluck('mobile')
            ->map(fn ($mobile) => $this->normalizeMobile((string) $mobile))
            ->filter()
            ->flip()
            ->all();

        $imported = 0;
        $replaced = 0;
        $duplicates = 0;
        $invalid = 0;
        $whatsappSent = 0;
        $seenInFile = [];

        @set_time_limit(0);

        foreach ($dataRows as $row) {
            if (!is_array($row) || $this->rowIsEmpty($row)) {
                continue;
            }

            $mobile = $this->normalizeMobile($this->cell($row, $columns['mobile']));
            $name = trim($this->cell($row, $columns['name']));

            if ($mobile === '' || strlen($mobile) !== 10) {
                $invalid++;
                continue;
            }

            if (isset($seenInFile[$mobile])) {
                $duplicates++;
                continue;
            }

            $createdAt = $this->parseCreatedAt($this->cell($row, $columns['created_at']));
            $payload = [
                'name' => $name !== '' ? $name : 'Lead',
                'mobile' => $mobile,
                'email' => $this->normalizeEmail($this->cell($row, $columns['email'])),
                'profession' => $this->mapProfession($this->cell($row, $columns['profession'])),
                'age_group' => $this->mapAgeGroup($this->cell($row, $columns['age_group'])),
                'challenge' => $this->mapChallenge($this->cell($row, $columns['challenge'])),
                'current_income' => $this->mapIncome($this->cell($row, $columns['income'])),
                'page' => $forcePage ? $defaultPage : $this->mapPage($this->cell($row, $columns['page']), $defaultPage),
                'source' => $source,
                'status' => $this->mapStatus($this->cell($row, $columns['status'])),
            ];

            if (isset($existingMobiles[$mobile])) {
                $inquiry = AiWealthInquiry::where('mobile', $mobile)->latest('id')->first();
                if (!$inquiry || !$replaceExisting) {
                    if ($sendWhatsapp && $inquiry && !WhatsAppService::hasSent($inquiry->id, 't0_welcome') && !WhatsAppService::hasSent($inquiry->id, 't0_welcome_29oct')) {
                        if (WhatsAppService::sendWelcomeMessage($inquiry)) {
                            $whatsappSent++;
                            usleep(200000);
                        }
                    }
                    $duplicates++;
                    $seenInFile[$mobile] = true;
                    continue;
                }

                $inquiry->fill($payload);
                if ($createdAt) {
                    $inquiry->created_at = $createdAt;
                    $inquiry->updated_at = $createdAt;
                }
                $inquiry->save();
                $seenInFile[$mobile] = true;
                $replaced++;

                if ($sendWhatsapp && WhatsAppService::sendWelcomeMessage($inquiry, true)) {
                    $whatsappSent++;
                    usleep(200000);
                }
                continue;
            }

            $inquiry = new AiWealthInquiry();
            $inquiry->fill($payload);
            if ($createdAt) {
                $inquiry->created_at = $createdAt;
                $inquiry->updated_at = $createdAt;
            }
            $inquiry->save();

            $existingMobiles[$mobile] = true;
            $seenInFile[$mobile] = true;
            $imported++;

            if ($sendWhatsapp && WhatsAppService::sendWelcomeMessage($inquiry)) {
                $whatsappSent++;
                usleep(200000);
            }
        }

        return compact('imported', 'replaced', 'duplicates', 'invalid', 'whatsappSent');
    }

    private function readFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());

        if (in_array($extension, ['csv', 'txt'], true)) {
            return $this->readCsv($file->getRealPath());
        }

        if ($extension === 'xlsx') {
            return $this->readXlsx($file->getRealPath());
        }

        throw new \RuntimeException('Please upload .xlsx or .csv file.');
    }

    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');
        if (!$handle) {
            throw new \RuntimeException('Unable to read CSV file.');
        }

        $contents = stream_get_contents($handle);
        fclose($handle);
        $contents = preg_replace('/^\xEF\xBB\xBF/', '', (string) $contents);
        $tmp = fopen('php://temp', 'r+');
        fwrite($tmp, $contents);
        rewind($tmp);

        $firstLine = fgets($tmp) ?: '';
        $delimiter = substr_count($firstLine, "\t") > substr_count($firstLine, ',') ? "\t" : ',';
        rewind($tmp);

        $rows = [];
        while (($data = fgetcsv($tmp, 0, $delimiter)) !== false) {
            $rows[] = $data;
        }
        fclose($tmp);

        return $rows;
    }

    private function readXlsx(string $path): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('Unable to read Excel file.');
        }

        $shared = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml) {
            $xml = $this->loadXml($sharedXml);
            if ($xml) {
                foreach ($xml->si as $si) {
                $text = '';
                foreach ($si->xpath('.//t') ?: [] as $node) {
                    $text .= (string) $node;
                }
                $shared[] = $text;
            }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();
        if (!$sheetXml) {
            throw new \RuntimeException('Excel sheet not found.');
        }

        $sheet = $this->loadXml($sheetXml);
        if (!$sheet) {
            throw new \RuntimeException('Unable to parse Excel sheet.');
        }

        $rows = [];
        foreach ($sheet->sheetData->row as $row) {
            $line = [];
            foreach ($row->c as $cell) {
                $ref = (string) $cell['r'];
                if (!preg_match('/^([A-Z]+)(\d+)$/', $ref, $match)) {
                    continue;
                }
                $col = $this->columnIndex($match[1]);
                $type = (string) $cell['t'];
                $value = '';
                if ($type === 's') {
                    $index = (int) $cell->v;
                    $value = $shared[$index] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = (string) ($cell->is->t ?? '');
                } else {
                    $value = (string) ($cell->v ?? '');
                }
                $line[$col] = trim($value);
            }
            if ($line === []) {
                continue;
            }
            ksort($line);
            $max = max(array_keys($line));
            $ordered = [];
            for ($i = 0; $i <= $max; $i++) {
                $ordered[] = $line[$i] ?? '';
            }
            $rows[] = $ordered;
        }

        return $rows;
    }

    private function loadXml(string $xml): ?\SimpleXMLElement
    {
        $xml = preg_replace('/<hyperlinks\b[\s\S]*?<\/hyperlinks>/i', '', $xml);
        $xml = preg_replace('/xmlns(:[A-Za-z0-9]+)?="[^"]*"/i', '', $xml);
        $xml = preg_replace('/(<\/?)([A-Za-z0-9]+):/', '$1', $xml);
        $xml = preg_replace('/\s+[A-Za-z0-9]+:([A-Za-z0-9_-]+)=/', ' $1=', $xml);

        $previous = libxml_use_internal_errors(true);
        $parsed = simplexml_load_string($xml);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return $parsed ?: null;
    }

    private function columnIndex(string $letters): int
    {
        $index = 0;
        foreach (str_split($letters) as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }

        return $index - 1;
    }

    private function findHeaderRow(array $rows): int
    {
        $limit = min(5, count($rows));
        for ($i = 0; $i < $limit; $i++) {
            $joined = $this->normalizeHeader(implode(' ', $rows[$i] ?? []));
            if (
                $this->headerContains($joined, ['phone', 'mobile', 'फोन', 'फ़ोन', 'नंबर', 'created_time', 'profession', 'lead_status'])
                || $this->headerContains($joined, ['ईमेल', 'email'])
            ) {
                return $i;
            }
        }

        return 0;
    }

    private function detectColumns(array $headers, array $dataRows = []): array
    {
        $map = [
            'name' => null,
            'mobile' => null,
            'email' => null,
            'profession' => null,
            'age_group' => null,
            'challenge' => null,
            'income' => null,
            'created_at' => null,
            'page' => null,
            'status' => null,
        ];

        foreach ($headers as $index => $header) {
            if ($header === '') {
                continue;
            }

            if ($map['name'] === null && $this->headerIsName($header)) {
                $map['name'] = $index;
            } elseif ($map['mobile'] === null && $this->headerIsPhone($header)) {
                $map['mobile'] = $index;
            } elseif ($map['email'] === null && $this->headerContains($header, ['email', 'ईमेल', 'इमेल'])) {
                $map['email'] = $index;
            } elseif ($map['profession'] === null && str_contains($header, 'profession')) {
                $map['profession'] = $index;
            } elseif ($map['age_group'] === null && (str_contains($header, 'age_group') || $header === 'age')) {
                $map['age_group'] = $index;
            } elseif ($map['challenge'] === null && (str_contains($header, 'challenge') || str_contains($header, 'business_challenge'))) {
                $map['challenge'] = $index;
            } elseif ($map['income'] === null && str_contains($header, 'income')) {
                $map['income'] = $index;
            } elseif ($map['page'] === null && ($header === 'page' || $header === 'landing_page' || $header === 'form_page')) {
                $map['page'] = $index;
            } elseif ($map['status'] === null && ($header === 'status' || $header === 'inquiry_status')) {
                $map['status'] = $index;
            } elseif ($map['created_at'] === null && (str_contains($header, 'created_time') || $header === 'created_at' || $header === 'created_date')) {
                $map['created_at'] = $index;
            }
        }

        foreach ($headers as $index => $header) {
            if ($header === 'lead_status' || $header === 'leadstatus') {
                if ($map['mobile'] === null && $index > 0) {
                    $map['mobile'] = $index - 1;
                }
                if ($map['email'] === null && $index > 1) {
                    $map['email'] = $index - 2;
                }
                if ($map['name'] === null && $index > 2) {
                    $map['name'] = $index - 3;
                }
            }
        }

        if ($map['mobile'] === null) {
            $map = $this->detectColumnsFromValues($map, $dataRows);
        }

        return $map;
    }

    private function detectColumnsFromValues(array $map, array $dataRows): array
    {
        $phoneScores = [];
        $emailScores = [];
        $sample = array_slice($dataRows, 0, 15);

        foreach ($sample as $row) {
            foreach ($row as $index => $value) {
                $value = trim((string) $value);
                if ($value === '') {
                    continue;
                }
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $emailScores[$index] = ($emailScores[$index] ?? 0) + 1;
                }
                $mobile = $this->normalizeMobile($value);
                if (strlen($mobile) === 10) {
                    $phoneScores[$index] = ($phoneScores[$index] ?? 0) + 1;
                }
            }
        }

        if ($map['mobile'] === null && $phoneScores !== []) {
            arsort($phoneScores);
            $map['mobile'] = (int) array_key_first($phoneScores);
        }
        if ($map['email'] === null && $emailScores !== []) {
            arsort($emailScores);
            $map['email'] = (int) array_key_first($emailScores);
        }

        return $map;
    }

    private function headerIsName(string $header): bool
    {
        if ($this->headerContains($header, ['full_name', 'fullname', 'नाम'])) {
            return true;
        }

        return $header === 'name';
    }

    private function headerIsPhone(string $header): bool
    {
        return $this->headerContains($header, [
            'phone',
            'mobile',
            'whatsapp',
            'फोन',
            'फ़ोन',
            'नंबर',
            'नम्बर',
        ]);
    }

    private function headerContains(string $header, array $needles): bool
    {
        foreach ($needles as $needle) {
            $needle = $this->normalizeHeader($needle);
            if ($needle !== '' && mb_strpos($header, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    private function normalizeHeader(string $header): string
    {
        $header = trim($header);
        if (class_exists(\Normalizer::class)) {
            $header = \Normalizer::normalize($header, \Normalizer::FORM_C) ?: $header;
        }
        $header = mb_strtolower($header);
        $header = str_replace(['–', '—', '-', ' '], '_', $header);
        $header = preg_replace('/[^\p{L}\p{M}\p{N}_]+/u', '_', $header);
        $header = preg_replace('/_+/', '_', $header);

        return trim((string) $header, '_');
    }

    private function normalizeMobile(string $value): string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';
        if (strlen($digits) >= 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, -10);
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, -10);
        } elseif (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return $digits;
    }

    private function normalizeEmail(string $value): ?string
    {
        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function mapProfession(string $value): ?string
    {
        $key = $this->slugValue($value);
        $map = [
            'student' => 'student',
            'student_fresher' => 'student',
            'job' => 'job',
            'job_employee' => 'job',
            'freelancer' => 'freelancer',
            'business' => 'business',
            'business_owner' => 'business',
            'coach' => 'coach',
            'coach_consultant' => 'coach',
            'other' => 'other',
        ];

        return $map[$key] ?? ($value !== '' ? 'other' : null);
    }

    private function mapAgeGroup(string $value): ?string
    {
        $key = $this->slugValue($value);
        $map = [
            '18_24' => '18-24',
            '25_34' => '25-34',
            '35_44' => '35-44',
            '45' => '45+',
            '45_plus' => '45+',
        ];

        return $map[$key] ?? ($value !== '' ? str_replace('_', '-', $key) : null);
    }

    private function mapChallenge(string $value): ?string
    {
        $key = $this->slugValue($value);
        if ($key === '') {
            return null;
        }
        if (str_contains($key, 'lead')) {
            return 'leads';
        }
        if (str_contains($key, 'sale')) {
            return 'sales';
        }
        if (str_contains($key, 'content') || str_contains($key, 'marketing')) {
            return 'content';
        }
        if (str_contains($key, 'automation')) {
            return 'automation';
        }
        if (str_contains($key, 'ai')) {
            return 'ai';
        }
        if (str_contains($key, 'mindset') || str_contains($key, 'consistency')) {
            return 'mindset';
        }
        if (str_contains($key, 'other')) {
            return 'other';
        }

        return 'other';
    }

    private function mapIncome(string $value): ?string
    {
        $key = $this->slugValue($value);
        if ($key === '') {
            return null;
        }
        if (str_contains($key, 'not_earning')) {
            return 'not-earning';
        }
        if (str_contains($key, 'plus')) {
            return '1.5l-plus';
        }
        if (str_contains($key, '1_5') || str_contains($key, '1l_1')) {
            return '1l-1.5l';
        }
        if (str_contains($key, '50') && str_contains($key, '70')) {
            return '50-70k';
        }
        if (str_contains($key, '70')) {
            return '70k-1l';
        }
        if (str_contains($key, '10') && str_contains($key, '20')) {
            return '10-20k';
        }
        if (str_contains($key, '20') && str_contains($key, '30')) {
            return '20-30k';
        }
        if (str_contains($key, '30') && str_contains($key, '50')) {
            return '30-50k';
        }

        return null;
    }

    private function mapPage(string $value, string $default): string
    {
        $key = $this->slugValue($value);
        if ($key === '') {
            return $default;
        }

        foreach (AiWealthInquiry::pageLabels() as $slug => $label) {
            if ($key === $this->slugValue($slug) || $key === $this->slugValue($label)) {
                return $slug;
            }
        }

        return $default;
    }

    private function mapStatus(string $value): string
    {
        $key = $this->slugValue($value);
        if (str_contains($key, 'partial')) {
            return 'partial';
        }

        return 'submitted';
    }

    private function slugValue(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = str_replace(['₹', 'rs', '–', '—', '-', '/', ' '], '_', $value);
        $value = preg_replace('/[^\p{L}\p{N}_]+/u', '_', $value);
        $value = preg_replace('/_+/', '_', $value);

        return trim((string) $value, '_');
    }

    private function parseCreatedAt(string $value): ?Carbon
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function cell(array $row, ?int $index): string
    {
        if ($index === null || !array_key_exists($index, $row)) {
            return '';
        }

        return trim((string) $row[$index]);
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }
}
