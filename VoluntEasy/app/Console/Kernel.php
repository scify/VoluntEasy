<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Inspire',
        'App\Console\Commands\CheckActions',
        'App\Console\Commands\CheckVolunteers',
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        $schedule->command('checkActions')
            ->everyMinute();

        $schedule->command('checkVolunteers')
            ->daily();

        $schedule->exec('php -d register_argc_argv=On /voluntaction/artisan checkActions');

    }

}
