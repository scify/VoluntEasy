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
	protected $name = 'testEmail';

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
        $end_dates = \DB::table('actions')->select('id', 'end_date', 'description', 'questionnaire_volunteers_link', 'questionnaire_action_link')->get();

        $week_check = Carbon::now()->addDays(7)->format('Y-m-d');
        $date_now = Carbon::now()->format('Y-m-d');

        /* TODO: Bring check 'if action ends in 7 days' up to be evaluate first. */
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
                    echo "\nVOLUNTEERS ARE: " . "\n";
                    /* Grab the questionnaire link and insert into $data array. */
                    $data = array('questionnaire' => $action_end_date->questionnaire_action_link);
                    \Mail::queue('emails.test', $data, function($message)
                    {
                        /* Join actions_volunteers with volunteers to check volunteers that belong to action. */
                        $mailqueue= \DB::table('actions_volunteers')->join('volunteers', 'actions_volunteers.id', '=', 'volunteers.id')->get();
                        $message->from('test@scify.org', 'Mr Test');
                        foreach($mailqueue as $notify_users)
                        {
                            $message->to($notify_users->email)->subject('Test subject');
                        }
                    });
                    /* Raw Mail testing. */
//                        \Mail::raw('This is text', function($message)
//                        {
//                            $mailqueue= \DB::table('actions_volunteers')->join('volunteers', 'actions_volunteers.id', '=', 'volunteers.id')->get();
//                            $message->from('test@scify.org', 'ACK');
//                            foreach($mailqueue as $notify_volunteers)
//                            {
//                            $message->to($notify_volunteers->email)->subject('email test');
//                            }
//                        });

//                        echo "  " . $notify_volunteers->email . "\n";
                    // Get all volunteers mail from action

                } else {
                    /* debug msg. TODO: remove. */
                    echo $action_end_date->end_date . " dates do not match for action " . $action_end_date->description . "\n";
                    /* continue; */
                }
            }
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
