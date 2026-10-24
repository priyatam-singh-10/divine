<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebinarReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webinar:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log::info('Webinar reminder cron started');


        $now = time();

        $webinars = DB::table('bootcamp_purchases as bp')
            ->join('bootcamps as b', 'b.id', '=', 'bp.bootcamp_id')
            ->join('bootcamp_modules as bm', 'bm.bootcamp_id', '=', 'b.id')
            ->join('bootcamp_live_classes as blc', 'blc.module_id', '=', 'bm.id')
            ->join('users as u', 'u.id', '=', 'bp.user_id')
            ->select(
                'u.name',
                'u.phone',
                'b.title',
                'b.publish_date',
                'blc.start_time',
                'blc.end_time',
                'blc.joining_data'
            )
            ->get();
            // Log::info('Webinar reminder found webinars: ' . $webinars->count());

        foreach ($webinars as $webinar) {
               
            $seconds_left = $webinar->start_time - $now;
        
            // Log::info('Seconds left: ' . $seconds_left); 
            $join_link = '';

            if ($webinar->joining_data) {
                $zoomData = json_decode($webinar->joining_data, true);
                $join_link = $zoomData['join_url'] ?? '';
            }

            $date = date('d M Y', $webinar->start_time);
            $start_time = date('h:i A', $webinar->start_time);
            $end_time   = date('h:i A', $webinar->end_time);

            $seconds_left = $webinar->start_time - $now;

            // 24 hoursटे reminder → 10 minute window
            if ($seconds_left <= 86400 && $seconds_left >= 85800) {  // 86400 - 600 = 85800
             
                $message =
                    "⏰ *Webinar Reminder (24 Hours Left)*\n\n" .
                    "Hello *{$webinar->name}*,\n\n" .
                    "Your webinar *{$webinar->title}* will start in approximately 24 hours.\n\n" .
                    "📅 *Date:* {$date}\n" .
                    "⏰ *Time:* {$start_time}\n\n" .
                    "🔗 *Join Link:*\n{$join_link}\n\n" .
                    "🙏 Regards,\n" .
                    "Divine Touch Team";
            // Log::info('Sending 24hr reminder to: ' . $webinar->phone);
                $this->sendWhatsapp($webinar->phone, $message);
            }
            
            // 1 टे reminder → 10 minute window
            if ($seconds_left <= 3600 && $seconds_left >= 3000) {  // 3600 - 600 = 3000
            
            
                $message =
                    "🚀 *Webinar Starting Soon (1 Hour Left)*\n\n" .
                    "Hello *{$webinar->name}*,\n\n" .
                    "Your webinar *{$webinar->title}* will start in less than 1 hour!\n\n" .
                    "📅 *Date:* {$date}\n" .
                    "⏰ *Time:* {$start_time}\n\n" .
                    "🔗 *Join Link:*\n{$join_link}\n\n" .
                    "🙏 Regards,\n" .
                    "Divine Touch Team";
            //   Log::info('Sending 1hr reminder to: ' . $webinar->phone);
                $this->sendWhatsapp($webinar->phone, $message);
            }
        }
    }
    private function sendWhatsapp($phone, $message)
    {
            // Log::info('WhatsApp API called for: ' . $phone);
        $message = urlencode($message);

        $url = "https://listingbook.in/divine?number={$phone}&message={$message}";

        try {
            file_get_contents($url);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
    }
}
