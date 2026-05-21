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
        // Check for high temperature conditions every 5 minutes
        $schedule->command('device:check-high-temperature')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->name('check-high-temperature')
            ->description('Check for high temperature conditions and send notifications');
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
