<?php

namespace App\Console\Commands;

use App\Services\CronService;
use Illuminate\Console\Command;

/**
 * Class CheckActions
 */
class CheckActions extends Command
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
    public function handle()
    {

        // remove, just a check
        $execution_time = microtime(true);

        $expired = $this->cronService->expiredActions();
        $toExpire = $this->cronService->toExpireActions();
        $notAvailablle = $this->cronService->notAvailableVolunteers();

        $execution_time = microtime(true) - $execution_time;
        $this->comment('Took '.$execution_time.' sec');
    }
}
