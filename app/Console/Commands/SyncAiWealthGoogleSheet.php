<?php

namespace App\Console\Commands;

use App\Services\AiWealthGoogleSheetSync;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncAiWealthGoogleSheet extends Command
{
    protected $signature = 'ai-wealth:sync-google-sheet';

    protected $description = 'Insert new AI Wealth leads from the Google Sheet';

    public function handle(AiWealthGoogleSheetSync $sync): int
    {
        try {
            $result = $sync->sync();
        } catch (\Throwable $e) {
            Log::warning('AI Wealth Google Sheet sync failed', [
                'error' => $e->getMessage(),
            ]);
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info(
            "Imported {$result['imported']}. Skipped {$result['duplicates']} duplicates. Invalid {$result['invalid']}."
        );

        return self::SUCCESS;
    }
}
