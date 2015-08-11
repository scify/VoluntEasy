<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Volunteer as Volunteer;
use App\Models\Action as Action;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class SendEmail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'TestEmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email to volunteers';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        /*
         * MAIL
        */

        //TODO: use Action::expireInSevenDays()->get();


        /* Get all end dates from actions table. */
        /* TODO: check where() clause to check date. */
        $end_dates = \DB::table('actions')->select('end_date', 'description')->get();

        $week_check = Carbon::now()->addDays(7)->format('Y-m-d');
        $date_now = Carbon::now()->format('Y-m-d');

        /* TODO: Use `continue;` to check if action->end_date < date(now) */
        foreach($end_dates as $action_end_date) {
            /* Find if an action end_date has already passed. If yes, do nothing.
             * If not, check if action ends in 7 days to fire mail questionnaires
             * to volunteers */
            if ($date_now > $action_end_date->end_date) {
                /* debug msg. */
                echo $action_end_date->description . " found a past action\n";
                continue;
            } else {
                if (strcmp($action_end_date->end_date, $week_check) === 0) {
                    /* debug msg. TODO: remove. */
                    echo $action_end_date->end_date . " dates match for action " . $action_end_date->description ."\n";
                } else {
                    /* debug msg. TODO: remove. */
                    echo $action_end_date->end_date . " dates do not match for action " . $action_end_date->description . "\n";
                    /* continue; */
                }
            }
        }

        /* Test: get all volunteers and parse emails with var_dump. */
        $volunteer_email_array = \DB::table('volunteers')->get();

        foreach($volunteer_email_array as $vol_email)
        {
            var_dump($vol_email->email);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			// ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
