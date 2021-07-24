<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ClearOldLogs::class,
        Commands\ClearTempFiles::class,
        Commands\PublishAnnouncements::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->command('model:prune')->daily();

        $schedule->command('announcements:publish')
            ->timezone('Asia/Kuala_Lumpur')
            ->daily(env('ANNOUNCEMENT_PUBLISH_TIME'));

        // $schedule->command('clear:logs')
        //     ->monthly();

        // $schedule->command('push:announcements')
        //     ->timezone('Asia/Kuala_Lumpur')
        //     ->daily(env('PUSH_NOTIFICATION_TIME'));

        // $schedule->command('credit:pending_points')
        //     ->timezone('Asia/Kuala_Lumpur')
        //     ->daily("08:00");

        // $schedule->command('update:vouchers')
        //     ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
