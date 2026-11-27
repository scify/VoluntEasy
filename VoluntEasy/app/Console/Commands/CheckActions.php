<?php namespace App\Console\Commands;

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

    private \App\Services\CronService $cronService;

    public function __construct(\App\Services\CronService $cronService) {
        parent::__construct();
        $this->cronService = $cronService;
    }

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

        //remove, just a check
        $execution_time = microtime(true);

        $expired = $this->cronService->expiredActions();
        $toExpire = $this->cronService->toExpireActions();
        $notAvailablle = $this->cronService->notAvailableVolunteers();

        $execution_time = microtime(true) - $execution_time;
        $this->comment('Took ' . $execution_time . ' sec');
    }

}
