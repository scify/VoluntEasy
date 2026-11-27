<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class CheckVolunteers
 * @package App\Console\Commands
 *
 * The volunteers sign a contract when they arrive at the organization.
 * The date is stored in a field. A notification is sent after 6 and 12 months. *
 *
 */
class CheckVolunteers extends Command {

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
    protected $name = 'checkVolunteers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check volunteers\' contract dates';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        //remove, just a check
        $execution_time = microtime(true);

        $expired = $this->cronService->expiredContracts();
        $toExpire = $this->cronService->toExpireContracts();

        $execution_time = microtime(true) - $execution_time;
        $this->comment('Took ' . $execution_time . ' sec');
    }

}
