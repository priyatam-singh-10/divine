<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('webinar:reminder')->everyMinute();
        $schedule->command('ai-wealth:whatsapp-flow')->everyMinute()->withoutOverlapping();
        $schedule->command('ai-wealth:sync-google-sheet')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
    //  protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('webinar:reminder')->everyMinute();
    // }
}
