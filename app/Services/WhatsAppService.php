<?php

namespace App\Services;

use App\Models\AiWealthInquiry;
use App\Models\AiWealthWhatsappLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class WhatsAppService
{
    public static function sendInquiryMessage(AiWealthInquiry $inquiry): void
    {
        self::sendWelcomeMessage($inquiry);
    }

    public static function sendWelcomeMessage(AiWealthInquiry $inquiry, bool $force = false): bool
    {
        if ($force) {
            return self::dispatch($inquiry, self::buildCongratulationsMessage($inquiry), null);
        }

        return self::sendTemplate($inquiry, 't0_welcome', self::buildCongratulationsMessage($inquiry), false);
    }

    public static function sendCongratulationsToAll(): array
    {
        @set_time_limit(0);

        $sent = 0;
        $skipped = 0;
        $failed = 0;
        $key = 't0_welcome_29oct';

        $inquiries = AiWealthInquiry::query()
            ->whereNotNull('mobile')
            ->where('mobile', '!=', '')
            ->orderBy('id')
            ->get();

        foreach ($inquiries as $inquiry) {
            $digits = preg_replace('/\D+/', '', (string) $inquiry->mobile);
            if (strlen($digits) < 10) {
                $failed++;
                continue;
            }

            if (self::hasSent($inquiry->id, $key)) {
                $skipped++;
                continue;
            }

            $ok = self::sendTemplate(
                $inquiry,
                $key,
                self::buildCongratulationsMessage($inquiry),
                false
            );

            if ($ok) {
                $sent++;
            } else {
                $failed++;
            }

            usleep(200000);
        }

        return compact('sent', 'skipped', 'failed');
    }

    public static function sendTemplate(AiWealthInquiry $inquiry, string $key, string $message, ?bool $withImage = null): bool
    {
        if (self::hasSent($inquiry->id, $key)) {
            return false;
        }

        $ok = self::dispatch($inquiry, $message, self::mediaUrlFor($key, $withImage));
        if ($ok) {
            self::markSent($inquiry->id, $key);
        }

        return $ok;
    }

    public static function mediaUrlFor(string $key, ?bool $withImage = null): ?string
    {
        $files = [
            't0_welcome' => 'A.png',
            't5_community' => 'B.png',
            't30_expect' => 'C.png',
            'd1_1h' => 'D1-B.png',
            'd1_30m' => 'D1-C.png',
            'd1_open' => 'D1-D.png',
            'd1_10m' => 'D1-E.png',
            'd1_live' => 'D1-F.png',
            'd1_teaser' => 'D1-G.png',
            'd2_morning' => 'D2-A.png',
            'd2_1h' => 'd2-b.jpg',
            'd2_30m' => 'd2-c.jpg',
            'd2_open' => 'd2-d.jpg',
            'd2_10m' => 'd2-e.jpg',
            'd2_live' => 'd2-f.jpg',
            'p1_thanks' => 'p1.jpg',
            'p2_assess' => 'p2.jpg',
            'p3_problem' => 'p3.jpg',
            'p4_offer' => 'p4.jpg',
        ];

        $mapped = $files[$key] ?? null;
        if ($withImage === false) {
            return null;
        }

        if ($mapped) {
            $base = rtrim((string) config('services.whatsapp.image_base_url'), '/');
            if ($base !== '') {
                return $base . '/' . $mapped;
            }
        }

        if ($withImage === true || $key === 't0_welcome') {
            $fallback = config('services.whatsapp.image_url');
            return !empty($fallback) ? $fallback : null;
        }

        return null;
    }

    public static function hasSent(int $inquiryId, string $key): bool
    {
        if (!Schema::hasTable('ai_wealth_whatsapp_logs')) {
            return false;
        }

        return AiWealthWhatsappLog::where('inquiry_id', $inquiryId)
            ->where('template_key', $key)
            ->exists();
    }

    public static function markSent(int $inquiryId, string $key): void
    {
        if (!Schema::hasTable('ai_wealth_whatsapp_logs')) {
            return;
        }

        AiWealthWhatsappLog::firstOrCreate(
            [
                'inquiry_id' => $inquiryId,
                'template_key' => $key,
            ],
            [
                'sent_at' => now(),
            ]
        );
    }

    private static function dispatch(AiWealthInquiry $inquiry, string $message, ?string $imageUrl): bool
    {
        $url = config('services.whatsapp.url');
        $token = config('services.whatsapp.token');
        $from = preg_replace('/\D+/', '', (string) config('services.whatsapp.from'));
        $messageType = config('services.whatsapp.message_type') ?: 'text';
        $requestType = config('services.whatsapp.request_type') ?: 'POST';

        if (!$url || !$token || !$from || empty($inquiry->mobile)) {
            return false;
        }

        $mobile = preg_replace('/\D+/', '', (string) $inquiry->mobile);
        if (strlen($mobile) === 10) {
            $number = '91' . $mobile;
        } elseif (strlen($mobile) === 12 && str_starts_with($mobile, '91')) {
            $number = $mobile;
        } else {
            $number = $mobile;
        }

        if (strlen($number) < 10) {
            return false;
        }

        $text = $message;
        if (!empty($imageUrl)) {
            $text .= "\n" . $imageUrl;
        }

        try {
            $response = Http::timeout(30)->asMultipart()->post($url, [
                ['name' => 'messageType', 'contents' => (string) $messageType],
                ['name' => 'token', 'contents' => (string) $token],
                ['name' => 'from', 'contents' => $from],
                ['name' => 'to', 'contents' => $number],
                ['name' => 'requestType', 'contents' => (string) $requestType],
                ['name' => 'text', 'contents' => $text],
            ]);

            $sent = $response->successful() && $response->json('success') === true;
            if (!$sent) {
                Log::warning('WhatsApp inquiry message failed', [
                    'inquiry_id' => $inquiry->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('WhatsApp inquiry message failed', [
                'inquiry_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public static function zoomLink(): string
    {
        return config('services.whatsapp.zoom_link') ?: 'https://us06web.zoom.us/j/89645866205?pwd=nUMMfKCa6LKKnkLPpavRQC38TuaOaq.1';
    }

    public static function communityLink(): string
    {
        return config('services.whatsapp.community_link') ?: 'https://chat.whatsapp.com/J6ofB4AWVOUKNQEKzaf7si';
    }


    private static function buildCongratulationsMessage(AiWealthInquiry $inquiry): string
    {
        $name = trim((string) $inquiry->name) ?: 'there';
        $community = self::communityLink();

        return "🎉 Congratulations {$name}!\n\n"
            . "आपकी seat successfully reserved है for:\n\n"
            . "🚀 AI Business Growth Accelerator Webinar\n\n"
            . "यह सिर्फ AI tools का webinar नहीं है.\n\n"
            . "इस webinar में हम सीखेंगे:\n"
            . "🤖 AI Tools for Business Growth\n"
            . "📈 AI से Business को Scale करना\n"
            . "📣 Marketing & Lead Generation\n"
            . "💰 Sales & Revenue Growth\n"
            . "⚙️ Business Automation & CRM\n\n"
            . "📅 29 OCT 2026\n"
            . "⏰ 7:30 PM – 9:30 PM\n"
            . "💻 LIVE on Zoom\n\n"
            . "अपने Business को AI की मदद से Grow करने के लिए तैयार हो जाइए! 🚀\n\n"
            . "👉 Exclusive WhatsApp Community:\n"
            . "{$community}\n\n"
            . "– Team Divine Touch";
    }
}
