<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Sync emails from all configured email addresses every 5 minutes
        $schedule->command('app:check-email')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/email-sync.log'));

        // Optional: Run a full sync every hour (catches any missed emails)
        $schedule->command('app:check-email')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/email-sync.log'));

        // Fetch incoming emails via IMAP every minute
        $schedule->command('email:fetch-incoming --limit=100')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/email-fetch.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
