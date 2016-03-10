<?php namespace App\Console\Commands;

use App\Services\Facades\CronService;
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
        $execution_time = microtime();

        $expired = CronService::expiredContracts();
        $toExpire = CronService::toExpireContracts();

        $execution_time = microtime() - $execution_time;
        $this->comment('Took ' . $execution_time . ' sec');
    }


}
