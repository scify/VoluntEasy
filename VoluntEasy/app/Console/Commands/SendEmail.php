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
        //$end_date = \DB::table('actions')->select('end_date')->get();
        $end_dates = Action::where('end_date', '>', Carbon::now()->addDays(7));
        //dd($end_dates);


        foreach($end_dates as $action_end_date)
        {

            dd($action_end_date);
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
