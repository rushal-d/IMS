<?php

namespace App\Console;

use App\Console\Commands\CheckShareMarket;
use App\Console\Commands\CheckStatus;
use App\Console\Commands\UpdateShareTable;
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
        CheckStatus::class,
        CheckShareMarket::class,
        UpdateShareTable::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('checkstatus')->everyMinute();
        /*$schedule->command('checkstatus')->everyMinute();
        
        $schedule->command('todayprice')->everyMinute()->appendOutputTo(base_path('cron.txt'));
        $schedule->command('updateshare')->everyMinute()->appendOutputTo(base_path('cron.txt'));
        
        $schedule->command('todayprice')->dailyAt('3:00:00')->appendOutputTo(base_path('cron.txt'));
        $schedule->command('updateshare')->dailyAt('3:20:00')->appendOutputTo(base_path('cron.txt'));
        
        $schedule->command('todayprice')->dailyAt('16:00:00')->appendOutputTo(base_path('cron.txt'));
        $schedule->command('updateshare')->dailyAt('16:10:00')->appendOutputTo(base_path('cron.txt'));*/
        $schedule->command('pull:share')->dailyAt('16:00:00');
        $schedule->command('pull:share')->dailyAt('16:30:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
