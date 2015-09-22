<?php namespace App\Console\Commands;

use App\Services\Facades\CronService;
use Illuminate\Console\Command;

/**
 * Class CheckActions
 * @package App\Console\Commands
 *
 * For the actions that expired yesterday, we should send some emails.
 *
 * [1]. send emails to all the volunteers that participated to the action
 * with a link to a questionnaire (rate the action).
 *
 * [2]. send an email to the person responsible for the action (the column email
 * at the action table) with another questionnaire link (rate all the volunteers)
 *
 */
class CheckActions extends Command {


    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'checkActions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find expired actions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        //dd(\Config::get('mail'));

        //remove, just a check
        $execution_time = microtime();

        $expired = CronService::expiredActions();
        $toExpire = CronService::toExpireActions();
        $notAvailablle = CronService::notAvailableVolunteers();


        //remove
        $this->comment(sizeof($expired) . '  actions expired yesterday');
        $this->comment($toExpire . '  actions expire in 7 days');
        $this->comment($notAvailablle . '  volunteers made available');


        $execution_time = microtime() - $execution_time;
        $this->comment('Took ' . $execution_time . ' sec');
    }


}
