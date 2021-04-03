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

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('toot:statuses-special')
                 ->hourlyAt(10);

        $schedule->command('toot:statuses')
                 ->hourlyAt(30);

        $schedule->command('toot:info')
                 ->dailyAt('08:00')
                 ->when(! app()->isLocal());

        $schedule->command('toot:version')
                 ->timezone('Asia/Tokyo')
                 ->dailyAt('23:20');

        $schedule->command('horizon:snapshot')->everyFiveMinutes();
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
