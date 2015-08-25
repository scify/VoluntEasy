<?php namespace App\Console\Commands;

use App\Models\Action as Action;
use App\Models\Descriptions\VolunteerStatus;
use App\Services\Facades\VolunteerService;
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

        $execution_time = microtime();

        $expiredActions = Action::expiredYesterday()->with('volunteers')->get();

        $this->comment(sizeof($expiredActions) . ' expired actions');


        foreach ($expiredActions as $expired) {

            //check that the action has a questionnaire link
            if ($expired->questionnaire_action_link != null && $expired->questionnaire_action_link != '' && sizeof($expired->volunteers) > 0 ) {

                //first send emails to all the volunteers
                foreach ($expired->volunteers as $volunteer) {

                    \Mail::send('emails.rate_action', ['volunteer' => $volunteer, 'action' => $expired], function ($message) use ($volunteer) {
                        $message->to($volunteer->email, $volunteer->name . ' ' . $volunteer->last_name)->subject('Test');
                    });

                    $this->comment('Send email to volunteer ' . $volunteer->name . ' ' . $volunteer->last_name . ' [' . $volunteer->email . ']');
                }
            } //remove
            else {
                $this->comment('didn\'t send questionnaire to volunteers (no volunteers or no questionnaire link)');
            }

            if ($expired->questionnaire_volunteers_link != null && $expired->questionnaire_volunteers_link != '' && $expired->email != null && $expired->email != '') {

                //then send an email to the person responsible for the action
                \Mail::send('emails.rate_volunteers', ['action' => $expired], function ($message) use ($expired) {
                    $message->to($expired->email, $expired->name)->subject('Test');
                });

                $this->comment('Send email to ' . $expired->name . ' [' . $expired->email . ']');
            }
            //remove
            else {
                $this->comment('didn\'t send questionnaire to responsible (no responsible or no questionnaire link)');
            }

            //for all volunteers, set their unit status to available
            foreach ($expired->volunteers as $volunteer) {
                $statusId = VolunteerStatus::available();

                VolunteerService::changeUnitStatus($volunteer->id, $expired->unit_id, $statusId);

                $this->comment('Setting ' . $volunteer->name .$volunteer->last_name . ' to available');
            }

            if (sizeof($expired->volunteers) > 0) {
                //detach all volunteers
                $expired->volunteers()->detach();
                $this->comment('Detached volunteers');
            }
        }

        $execution_time = microtime() - $execution_time;
        $this->comment('Took '.$execution_time.' sec');

    }
}
