<?php namespace App\Services;

use App\Models\Action;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Rating\ActionRating;
use App\Models\Rating\ActionScore;
use App\Models\Volunteer;
use App\Services\Facades\NotificationService as NotificationServiceFacade;
use App\Services\Facades\VolunteerService as VolunteerServiceFacade;

class CronService {

    public function expiredActions() {

        $expiredActions = Action::expiredYesterday()->with('volunteers.workDates', 'users', 'tasks.subtasks.workDates')->get();

        foreach ($expiredActions as $expired) {

            //check that the action has a questionnaire link
            if (sizeof($expired->volunteers) > 0) {

                //first send emails to all the volunteers
                foreach ($expired->volunteers as $volunteer) {

                    $token = str_random(30);
                    //create a new action rating
                    //with the action id, the email and the token
                    $actionScore = new ActionScore([
                        "action_id" => $expired->id,
                        "token" => $token,
                    ]);

                    $actionScore->save();

                    //then send an email to the volunteer
                    \Mail::send('app_emails.rate_action', ['volunteer' => $volunteer, 'action' => $expired, 'token' => $token], function ($message) use ($volunteer) {
                        $message->to($volunteer->email, $volunteer->name . ' ' . $volunteer->last_name)->subject('[VoluntEasy] Αξιολόγηση δράσης');
                    });
                }
            }


            //send emails to all action users to reate volunteers
            foreach ($expired->users as $user) {
                $token = str_random(30);
                //create a new action rating
                //with the action id, the email and the token
                $actionRating = new ActionRating([
                    "action_id" => $expired->id,
                    "email" => $expired->email,
                    "token" => $token,
                ]);

                $actionRating->save();

                //then send an email to the person responsible for the action

                \Mail::send('app_emails.rate_volunteers', ['action' => $expired, 'token' => $token], function ($message) use ($user, $expired) {
                    $message->to($user->email, $user->name.' '.$user->last_name)->subject('[VoluntEasy] Αξιολόγηση εθελοντών');
                });
            }

            $workDates = [];
            foreach ($expired->tasks as $task) {
                foreach ($task->subtasks as $subtask) {
                    foreach ($subtask->workDates as $workDate) {
                        array_push($workDates, $workDate->id);
                    }
                }
            }

            //for all volunteers, set their unit status to available
            foreach ($expired->volunteers as $volunteer) {
                $statusId = VolunteerStatus::available();
                VolunteerServiceFacade::changeUnitStatus($volunteer->id, $expired->unit_id, $statusId);

                foreach ($volunteer->workDates as $workDate) {
                    if (in_array($workDate->id, $workDates))
                        $volunteer->workDates()->detach($workDate->id);
                }
            }


            if (sizeof($expired->volunteers) > 0) {
                //detach all volunteers
                $expired->volunteers()->detach();
            }

            //notify users that action has expired
            NotificationServiceFacade::actionExpired($expired->id);
        }

        return $expiredActions;
    }


    /**
     * Notify users about to expire actions
     */
    public function toExpireActions() {

        //get all the active actions
        $actives = Action::active()->get();
        $count = 0;

        foreach ($actives as $action) {

            //get the start, end dates in Carbon format
            $startDate = \Carbon::createFromFormat('d/m/Y', $action->start_date);
            $endDate = \Carbon::createFromFormat('d/m/Y', $action->end_date);

            //calculate the duration of the action and get the half of it
            //since we want to notify the user when the action is halfway
            $durationHalf = intval($endDate->diffInDays($startDate) / 2);

            $now = \Carbon::now();

            //if the time is right (that is if today is the same day as
            //start_date + durationHalf, notify the users
            if ($startDate->addDays($durationHalf)->diffInDays($now) == 0) {
                NotificationServiceFacade::actionWillExpire($action->id);
                $count++;
            }
        }

        return $count;
    }


    /**
     * Get the not available volunteers.
     * If the end date of the status is equal to now,
     * then set the volunteer to available again
     */
    public function notAvailableVolunteers() {

        $notAvailableVolunteers = Volunteer::notAvailable()->get();
        $count = 0;

        if (sizeof($notAvailableVolunteers) > 0) {
            $notAvailableVolunteers->load('statusDuration.status');

            foreach ($notAvailableVolunteers as $volunteer) {

                if (sizeof($volunteer->statusDuration) > 0) {

                    $now = \Carbon::now();
                    $to = \Carbon::createFromFormat('d/m/Y', $volunteer->statusDuration[0]->to_date);

                    //set as available again
                    if ($now->diffInDays($to) == 1) {
                        VolunteerServiceFacade::setVolunteerToAvailable($volunteer->statusDuration[0]->id);
                        $count++;
                    }
                }
            }
        }
        return $count;
    }


    /**
     * Get the expired contracts and notify users
     */
    public function expiredContracts() {

        $expiredContracts = Volunteer::expiredContract()->with('units.users')->get();

        foreach ($expiredContracts as $volunteer) {
            NotificationServiceFacade::volunteerContractExpired($volunteer);
        }

        return;
    }

    /**
     * Get the contracts about to expire and notify users
     */
    public function toExpireContracts() {

        $toExpireContracts = Volunteer::toExpireContract()->with('units.users')->get();

        foreach ($toExpireContracts as $volunteer) {
            NotificationServiceFacade::volunteerContractToExpire($volunteer);
        }

        return;
    }

}
