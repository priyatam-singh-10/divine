<?php

namespace App\Services;

use App\Models\AiWealthInquiry;
use Illuminate\Support\Carbon;

class AiWealthWhatsappFlowService
{
    public function processDueMessages(int $limit = 80): int
    {
        $now = Carbon::now('Asia/Kolkata');
        $sent = 0;

        $inquiries = AiWealthInquiry::query()
            ->where('status', 'submitted')
            ->whereNotNull('mobile')
            ->orderBy('id')
            ->get();

        foreach ($inquiries as $inquiry) {
            $keys = $this->dueTemplateKeys($inquiry, $now);
            if ($keys === []) {
                continue;
            }

            $key = $keys[0];
            $message = $this->messageFor($key, $inquiry);
            if ($message === '') {
                continue;
            }

            if (WhatsAppService::sendTemplate($inquiry, $key, $message)) {
                $sent++;
                usleep(200000);
                if ($sent >= $limit) {
                    return $sent;
                }
            }
        }

        return $sent;
    }

    private function dueTemplateKeys(AiWealthInquiry $inquiry, Carbon $now): array
    {
        $keys = [];
        foreach ($this->schedule() as $key => $rule) {
            if (WhatsAppService::hasSent($inquiry->id, $key)) {
                continue;
            }

            $due = $this->dueAt($inquiry, $rule);
            $until = $this->untilAt($inquiry, $rule, $due);
            if ($now->gte($due) && $now->lte($until)) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    private function dueAt(AiWealthInquiry $inquiry, array $rule): Carbon
    {
        if ($rule['type'] === 'relative') {
            return Carbon::parse($inquiry->created_at, 'Asia/Kolkata')->addMinutes($rule['minutes']);
        }

        return Carbon::parse($rule['at'], 'Asia/Kolkata');
    }

    private function untilAt(AiWealthInquiry $inquiry, array $rule, Carbon $due): Carbon
    {
        if (!empty($rule['catchup_minutes'])) {
            return $due->copy()->addMinutes((int) $rule['catchup_minutes']);
        }

        return Carbon::parse($rule['until'], 'Asia/Kolkata');
    }

    private function schedule(): array
    {
        return [
            'oct29_1h' => ['type' => 'absolute', 'at' => '2026-10-29 18:30:00', 'until' => '2026-10-29 18:55:00'],
            'oct29_30m' => ['type' => 'absolute', 'at' => '2026-10-29 19:00:00', 'until' => '2026-10-29 19:20:00'],
            'oct29_5m' => ['type' => 'absolute', 'at' => '2026-10-29 19:25:00', 'until' => '2026-10-29 19:29:59'],
        ];
    }

    private function messageFor(string $key, AiWealthInquiry $inquiry): string
    {
        $name = trim((string) $inquiry->name) ?: 'there';
        $zoom = WhatsAppService::zoomLink();
        $community = WhatsAppService::communityLink();

        return match ($key) {
            'oct29_1h' => "🚨 ONLY 1 HOUR TO GO!\n\n"
                . "{$name}, AI Business Growth Accelerator Webinar 1 hour me start hoga.\n\n"
                . "📅 29 OCT 2026\n"
                . "⏰ 7:30 PM – 9:30 PM\n"
                . "💻 LIVE on Zoom\n\n"
                . "📝 Notebook ready\n"
                . "📶 Internet ready\n"
                . "💻 Laptop ready\n\n"
                . "🔗 Zoom:\n{$zoom}\n\n"
                . "👉 Community:\n{$community}\n\n"
                . "See you LIVE at 7:30 PM! 🚀",

            'oct29_30m' => "⏰ 30 MINUTES TO GO!\n\n"
                . "{$name}, AI Business Growth Accelerator Webinar 30 minutes me start hoga.\n\n"
                . "📅 29 OCT 2026\n"
                . "⏰ 7:30 PM – 9:30 PM\n"
                . "💻 LIVE on Zoom\n\n"
                . "🔗 Join Zoom:\n{$zoom}\n\n"
                . "👉 Community:\n{$community}\n\n"
                . "Thodi der pehle join kar lijiye. 🚀",

            'oct29_5m' => "🔔 5 MINUTES TO GO!\n\n"
                . "{$name}, AI Business Growth Accelerator Webinar 5 minutes me LIVE hai.\n\n"
                . "📅 29 OCT 2026\n"
                . "⏰ 7:30 PM – 9:30 PM\n"
                . "💻 LIVE on Zoom\n\n"
                . "🔗 Join now:\n{$zoom}\n\n"
                . "👉 Community:\n{$community}\n\n"
                . "Miss mat kijiyega. 🔴",

            default => '',
        };
    }
}
