<?php

namespace App\Console\Commands;

use App\Services\AiWealthWhatsappFlowService;
use Illuminate\Console\Command;

class AiWealthWhatsappFlow extends Command
{
    protected $signature = 'ai-wealth:whatsapp-flow';

    protected $description = 'Send due AI Wealth WhatsApp automation messages';

    public function handle(AiWealthWhatsappFlowService $flow): int
    {
        $sent = $flow->processDueMessages();
        $this->info("WhatsApp flow sent {$sent} message(s).");

        return self::SUCCESS;
    }
}
