<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void{
            $schedule->command('app:delete-expired-users')->everyMinute()
            ->appendOutputTo('storage/logs/scheduler.log');
        }
     /**
     * Register the commands for the application.
     */
    protected function commands(): void{

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

        
    }
    protected $commands = [
        \App\Console\Commands\DeleteExpiredUsers::class,
    ];
        
}
