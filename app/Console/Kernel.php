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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('stock:tradingview:companies spx')->weekdays()->at('15:55');
        $schedule->command('stock:tradingview:companies ndx')->weekdays()->at('15:58');
        // $schedule->command('stock:yf:historical:all')->weekdays()->at('16:05');
        // 由于数据源有延迟退后一个小时试试
        $schedule->command('stock:yf:historical:all')->weekdays()->at('17:05');
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

    protected function scheduleTimezone()
    {
        return 'America/New_York';
    }
}
