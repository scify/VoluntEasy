<?php

namespace App\Console\Commands;

use App\Services\CronService;
use Illuminate\Console\Command;

/**
 * Class CheckVolunteers
 */
class CheckVolunteers extends Command
{
    private CronService $cronService;

    public function __construct(CronService $cronService)
    {
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
    public function handle()
    {

        // remove, just a check
        $execution_time = microtime(true);

        $expired = $this->cronService->expiredContracts();
        $toExpire = $this->cronService->toExpireContracts();

        $execution_time = microtime(true) - $execution_time;
        $this->comment('Took '.$execution_time.' sec');
    }
}
