<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiWealthGoogleSheetSync
{
    public function __construct(private AiWealthLeadImporter $importer)
    {
    }

    public function sync(): array
    {
        $rows = $this->fetchRows();

        return $this->importer->importRows($rows, true, 'google-sheet', 'meta-ads', true);
    }

    private function fetchRows(): array
    {
        $id = trim((string) config('services.ai_wealth_sheet.id'));
        $gid = trim((string) config('services.ai_wealth_sheet.gid'));
        if ($id === '') {
            $id = '1wAeg1Y4WMnNThQBHw-RUU_nGvmpPcAdhQPTSBYTqR0s';
        }
        if ($gid === '') {
            $gid = '0';
        }

        $url = 'https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid;
        $response = Http::timeout(30)
            ->withHeaders(['User-Agent' => 'DivineTouchSheetSync'])
            ->get($url);

        $body = (string) $response->body();
        if (!$response->successful() || $this->looksLikeHtml($body)) {
            Log::warning('AI Wealth Google Sheet could not be read', [
                'status' => $response->status(),
            ]);
            throw new \RuntimeException('Google Sheet is not readable. Share it as Anyone with the link can view.');
        }

        return $this->parseCsv($body);
    }

    private function looksLikeHtml(string $body): bool
    {
        $start = ltrim($body);

        return str_starts_with($start, '<') || str_starts_with($start, '<!');
    }

    private function parseCsv(string $contents): array
    {
        $contents = preg_replace('/^\xEF\xBB\xBF/', '', $contents);
        $tmp = fopen('php://temp', 'r+');
        fwrite($tmp, $contents);
        rewind($tmp);

        $rows = [];
        while (($data = fgetcsv($tmp)) !== false) {
            $rows[] = $data;
        }
        fclose($tmp);

        return $rows;
    }
}
