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
            't5_community' => ['type' => 'relative', 'minutes' => 5, 'until' => '2026-09-19 18:00:00'],
            't30_expect' => ['type' => 'relative', 'minutes' => 30, 'until' => '2026-09-19 18:00:00'],
            'd0_tomorrow' => ['type' => 'absolute', 'at' => '2026-09-17 09:00:00', 'until' => '2026-09-17 20:00:00'],
            'd1_morning' => ['type' => 'absolute', 'at' => '2026-09-18 09:00:00', 'until' => '2026-09-18 18:10:00'],
            'd1_1h' => ['type' => 'absolute', 'at' => '2026-09-18 18:15:00', 'until' => '2026-09-18 18:43:00'],
            'd1_30m' => ['type' => 'absolute', 'at' => '2026-09-18 18:45:00', 'until' => '2026-09-18 18:58:00'],
            'd1_open' => ['type' => 'absolute', 'at' => '2026-09-18 19:00:00', 'until' => '2026-09-18 19:12:00'],
            'd1_10m' => ['type' => 'absolute', 'at' => '2026-09-18 19:05:00', 'until' => '2026-09-18 19:14:00'],
            'd1_live' => ['type' => 'absolute', 'at' => '2026-09-18 19:15:00', 'until' => '2026-09-18 19:40:00'],
            'd1_teaser' => ['type' => 'absolute', 'at' => '2026-09-18 21:30:00', 'until' => '2026-09-19 10:00:00'],
            'd2_morning' => ['type' => 'absolute', 'at' => '2026-09-19 09:00:00', 'until' => '2026-09-19 16:30:00'],
            'd2_1h' => ['type' => 'absolute', 'at' => '2026-09-19 18:15:00', 'until' => '2026-09-19 18:43:00'],
            'd2_30m' => ['type' => 'absolute', 'at' => '2026-09-19 18:45:00', 'until' => '2026-09-19 18:58:00'],
            'd2_open' => ['type' => 'absolute', 'at' => '2026-09-19 19:00:00', 'until' => '2026-09-19 19:12:00'],
            'd2_10m' => ['type' => 'absolute', 'at' => '2026-09-19 19:05:00', 'until' => '2026-09-19 19:14:00'],
            'd2_live' => ['type' => 'absolute', 'at' => '2026-09-19 19:15:00', 'until' => '2026-09-19 19:40:00'],
            'p1_thanks' => ['type' => 'absolute', 'at' => '2026-09-19 21:30:00', 'until' => '2026-09-20 10:00:00'],
            'p2_assess' => ['type' => 'absolute', 'at' => '2026-09-20 09:00:00', 'until' => '2026-09-20 20:00:00'],
            'p3_problem' => ['type' => 'absolute', 'at' => '2026-09-21 09:00:00', 'until' => '2026-09-21 16:00:00'],
            'p4_offer' => ['type' => 'absolute', 'at' => '2026-09-21 18:00:00', 'until' => '2026-09-22 12:00:00'],
            'p_nurture' => ['type' => 'absolute', 'at' => '2026-09-23 09:00:00', 'until' => '2026-09-23 20:00:00'],
        ];
    }

    private function messageFor(string $key, AiWealthInquiry $inquiry): string
    {
        $name = trim((string) $inquiry->name) ?: 'there';
        $zoom = WhatsAppService::zoomLink();
        $community = WhatsAppService::communityLink();

        return match ($key) {
            't5_community' => "👋 {$name}, एक important step बाकी है.\n\n"
                . "Exclusive WhatsApp Community join कर लें. यहाँ webinar updates, reminders, resources और important announcements मिलेंगे.\n\n"
                . "👉 Join Community:\n{$community}\n\n"
                . "और आपकी convenience के लिए दोनों दिन के LIVE Zoom links:\n\n"
                . "🧠 DAY 1 — 18 September | 7:15 PM\n🔗 {$zoom}\n\n"
                . "🤖 DAY 2 — 19 September | 7:15 PM\n🔗 {$zoom}\n\n"
                . "💻 दोनों sessions के लिए laptop + notebook ready रखें.\n\n"
                . "Community join करके “DONE” reply कर दें. ✅",

            't30_expect' => "{$name}, एक important बात पहले ही clear कर दूँ 👇\n\n"
                . "यह webinar सिर्फ ChatGPT या automation tools सीखने के लिए नहीं है.\n\n"
                . "DAY 1 🧠\nWealth Psychology • Money Beliefs • Mind Reprogramming • Future Self\n\n"
                . "DAY 2 🤖\nAI Opportunities • Marketing • Lead Generation • Sales • WhatsApp Automation • CRM • Business Growth\n\n"
                . "Simple journey:\nMindset → Opportunity → Marketing → Sales → System → Growth\n\n"
                . "See you LIVE! 🚀",

            'd0_tomorrow' => "🔥 {$name}, कल webinar शुरू हो रहा है!\n\n"
                . "🚀 Wealth Psychology Reset + AI Wealth Blueprint Workshop\n\n"
                . "📅 18 & 19 September 2026\n⏰ 07:15 PM – 09:15 PM IST\n💻 LIVE on Zoom\n\n"
                . "🧠 Day 1: Mindset & Wealth Psychology\n🤖 Day 2: AI, Marketing, Sales, CRM & Growth\n\n"
                . "🔗 Zoom:\n{$zoom}\n\n"
                . "👉 Community:\n{$community}",

            'd1_morning' => "🔥 THE DAY IS HERE!\n\n"
                . "{$name}, आज आपका Day 1 — Wealth Psychology Reset है.\n\n"
                . "📅 18 September 2026\n⏰ 07:15 PM – 09:15 PM IST\n💻 LIVE on Zoom\n\n"
                . "🧠 Money & wealth beliefs\n🔄 Mind reprogramming\n👁️ Future-self visualization\n💪 Confidence, identity & growth\n✨ Wealth-focused action practice\n\n"
                . "🔴 LIVE participation is important. No recording/replay.\n💻 Notebook + quiet space ready रखें.\n\n"
                . "🔗 DAY 1 Zoom:\n{$zoom}\n\n"
                . "See you at 7:15 PM. 🔥",

            'd1_1h' => "🚨 ONLY 1 HOUR TO GO!\n\n"
                . "Day 1 — Wealth Psychology Reset starts at 7:15 PM.\n\n"
                . "📝 Notebook ready\n🧘 Quiet space ready\n📶 Internet ready\n🧠 Open mind ready\n\n"
                . "🔗 Your Zoom Link:\n{$zoom}\n\n"
                . "🔴 Live-only session. Don't miss the exercises.\n\n"
                . "See you LIVE in 1 hour!",

            'd1_30m' => "⏰ 30 MINUTES TO GO!\n\n"
                . "🚀 Day 1 begins at 7:15 PM.\n🎵 Zoom room opens at 7:00 PM — join early and settle in.\n\n"
                . "📝 Notebook ready\n🧠 Open mind ready\n\n"
                . "🔗 Zoom:\n{$zoom}\n\n"
                . "See you inside! 🔥",

            'd1_open' => "🟢 🎉 ZOOM ROOM IS OPEN!\n\n"
                . "Day 1 room is now open.\n\n"
                . "🎵 Music is ON\n💬 Chat is OPEN\n🙌 Come say Hi!\n\n"
                . "⏰ Main session 7:15 PM से शुरू होगा.\n\n"
                . "🔗 JOIN ZOOM NOW:\n{$zoom}\n\n"
                . "Join early and get settled. 🚀",

            'd1_10m' => "🔔 10 MINUTES!\n\n"
                . "{$name}, we're going LIVE at 7:15 PM.\n\n"
                . "आज का पहला step:\n🧠 Reset the way you think about Wealth.\n\n"
                . "🔗 Join:\n{$zoom}\n\n"
                . "Don't just attend. Participate. 🚀",

            'd1_live' => "🔴 WE ARE LIVE!\n\n"
                . "{$name}, Day 1 अभी शुरू हो चुका है.\n\n"
                . "आज हम Wealth Psychology, mindset, limiting beliefs और future-self exercises पर काम कर रहे हैं.\n\n"
                . "👉 JOIN LIVE:\n{$zoom}\n\n"
                . "Join now — session is LIVE! 🔥",

            'd1_teaser' => "🧠 DAY 1 COMPLETE.\n\n"
                . "आज हमने mindset और wealth thinking पर काम किया.\n\n"
                . "अब सवाल:\nअगर thinking बदल जाए, तो उसे income & business growth में कैसे convert करें?\n\n"
                . "यही है DAY 2. 🚀\n\n"
                . "🤖 AI Opportunities\n📣 Marketing & Lead Generation\n💬 WhatsApp Automation\n📊 CRM & Funnels\n💰 Sales Systems\n📈 Business Growth\n\n"
                . "📅 19 September | 7:15 PM\n🔗 DAY 2 Zoom:\n{$zoom}\n\n"
                . "कल mindset से system की तरफ बढ़ेंगे. See you tomorrow!",

            'd2_morning' => "🔥 DAY 2 — TODAY!\n\n"
                . "आज हम mindset से execution & business growth पर आएंगे.\n\n"
                . "🤖 AI Tools & Opportunity Mapping\n📣 Marketing & Lead Generation\n💬 WhatsApp Automation\n📊 CRM & Funnels\n💰 Sales Scripts & Follow-up\n🚀 Business Growth Systems\n\n"
                . "📅 19 September 2026\n⏰ 07:15 PM – 09:15 PM IST\n💻 LIVE on Zoom\n\n"
                . "💻 Laptop ready रखें — practical, hands-on session.\n\n"
                . "🔗 DAY 2 Zoom:\n{$zoom}\n\n"
                . "See you LIVE! 🚀",

            'd2_1h' => "🤖 DAY 2 STARTS IN 1 HOUR!\n\n"
                . "आज का flow:\nAI → Marketing → Leads → Sales → CRM → Automation → Growth\n\n"
                . "💻 Laptop ready\n📝 Notebook ready\n📶 Internet ready\n\n"
                . "🔗 JOIN LIVE:\n{$zoom}\n\n"
                . "See you at 7:15 PM! 🚀",

            'd2_30m' => "🔥 30 MINUTES TO GO!\n\n"
                . "आज हम practical तरीके से देखेंगे:\n🤖 AI\n📣 Marketing\n🎯 Lead Generation\n💰 Sales\n💬 WhatsApp\n📊 CRM\n⚡ Automation\n\n"
                . "🎵 Zoom room opens at 7:00 PM.\n\n"
                . "🔗 Join:\n{$zoom}\n\n"
                . "Let's build! 🚀",

            'd2_open' => "🟢 🎉 ZOOM ROOM IS OPEN!\n\n"
                . "Day 2 room is now open.\n\n"
                . "🎵 Music is ON\n💬 Chat is OPEN\n🙌 Come say Hi!\n\n"
                . "⏰ Main session 7:15 PM से शुरू होगा.\n\n"
                . "🔗 JOIN ZOOM NOW:\n{$zoom}\n\n"
                . "Join early and get settled. 🚀",

            'd2_10m' => "🚨 10 MINUTES TO GO!\n\n"
                . "Day 2 is about turning:\nAI + Marketing + Sales + Automation\ninto a practical Business Growth System.\n\n"
                . "🔗 Join:\n{$zoom}\n\n"
                . "We're going LIVE at 7:15 PM. 🔴",

            'd2_live' => "🔴 LIVE NOW!\n\n"
                . "{$name}, Day 2 अभी LIVE है.\n\n"
                . "आज practical business growth systems पर काम हो रहा है:\n🤖 AI\n📣 Marketing\n🎯 Leads\n💰 Sales\n📊 CRM\n⚡ Automation\n\n"
                . "अगर अभी तक join नहीं किया:\n👉 {$zoom}\n\n"
                . "Join now. 🚀",

            'p1_thanks' => "🙏 Thank You {$name}!\n\n"
                . "पिछले 2 दिनों में हमने journey देखी:\n\n"
                . "🧠 Mindset & Wealth Psychology\n↓\n💡 AI Opportunities\n↓\n📣 Marketing & Lead Generation\n↓\n💰 Sales\n↓\n⚙️ Automation + CRM\n↓\n📈 Business Growth\n\n"
                . "Knowledge तभी valuable है जब वह action में जाए.\n\n"
                . "अगले message में हम आपको next step identify करने में help करेंगे.\n\n"
                . "Stay connected. 🚀",

            'p2_assess' => "Good morning {$name} 👋\n\n"
                . "एक honest question:\nआप अभी किस area में सबसे ज्यादा help चाहते हैं?\n\n"
                . "1️⃣ Mindset & direction\n2️⃣ AI skills & opportunities\n3️⃣ Marketing & leads\n4️⃣ Sales & conversion\n5️⃣ WhatsApp / CRM / automation\n6️⃣ Complete business growth system\n\n"
                . "बस 1–6 में से अपना number reply करें.\nआपके answer के आधार पर next step suggest किया जाएगा. 🚀",

            'p3_problem' => "{$name}, एक important realization 👇\n\n"
                . "AI tools की कमी नहीं है.\nChatGPT है. Claude है. CRM हैं. Automation tools हैं. Ads हैं.\n\n"
                . "Challenge अक्सर यह होता है:\nक्या use करें?\nकिस business problem के लिए use करें?\nकब use करें?\nऔर इन सबको एक system में कैसे जोड़ें?\n\n"
                . "इसीलिए हमारा approach है:\nMindset → Strategy → Marketing → Sales → AI → Automation → Growth\n\n"
                . "यानी सिर्फ tools नहीं — complete business growth system.",

            'p4_offer' => "🚀 WHAT'S NEXT?\n\n"
                . "अगर आप webinar की learning को सिर्फ सुनकर छोड़ना नहीं चाहते और उसे अपने business/career में implement करना चाहते हैं, तो structured next step है:\n\n"
                . "AI Business Growth Accelerator\n\n"
                . "Focus:\n🧠 Wealth & Growth Mindset\n🤖 AI & Opportunity Mapping\n📣 Marketing & Lead Generation\n💰 Sales\n💬 WhatsApp Automation\n📊 CRM & Funnel\n⚙️ Business Automation\n📈 Growth Systems\n\n"
                . "Details चाहिए तो reply करें:\nACCELERATOR\n\n"
                . "Team आपको complete details share करेगी.",

            'p_nurture' => "{$name}, webinar ke baad ek simple reminder 👇\n\n"
                . "Mindset + AI + Marketing + Sales + CRM ko ek system banana hi growth ka next step hai.\n\n"
                . "Agar aap start karna chahte ho, reply karein:\nACCELERATOR\nCRM\nCALL\n\n"
                . "Team aapka next step share karegi. 🚀",

            default => '',
        };
    }
}
