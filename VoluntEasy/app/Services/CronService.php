<?php namespace App\Services;

use App\Models\Action;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Services\Facades\NotificationService as NotificationServiceFacade;
use App\Services\Facades\VolunteerService as VolunteerServiceFacade;

class CronService {

    public function expiredActions(){

        $expiredActions = Action::expiredYesterday()->with('volunteers')->get();

        foreach ($expiredActions as $expired) {

            //check that the action has a questionnaire link
            if ($expired->questionnaire_action_link != null && $expired->questionnaire_action_link != '' && sizeof($expired->volunteers) > 0) {

                //first send emails to all the volunteers
                foreach ($expired->volunteers as $volunteer) {

                    \Mail::send('emails.rate_action', ['volunteer' => $volunteer, 'action' => $expired], function ($message) use ($volunteer) {
                        $message->to($volunteer->email, $volunteer->name . ' ' . $volunteer->last_name)->subject('Test');
                    });
                }
            }

            if ($expired->questionnaire_volunteers_link != null && $expired->questionnaire_volunteers_link != '' && $expired->email != null && $expired->email != '') {

                //then send an email to the person responsible for the action
                \Mail::send('emails.rate_volunteers', ['action' => $expired], function ($message) use ($expired) {
                    $message->to($expired->email, $expired->name)->subject('Test');
                });
            }

            //for all volunteers, set their unit status to available
            foreach ($expired->volunteers as $volunteer) {
                $statusId = VolunteerStatus::available();

                VolunteerServiceFacade::changeUnitStatus($volunteer->id, $expired->unit_id, $statusId);
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
     * notify users about to expire actions
     */
    public function toExpireActions() {
        $expireIn7DaysActions = Action::expireInSevenDays()->get();

        //notify users about to expire actions
        foreach ($expireIn7DaysActions as $toExpire) {
            NotificationServiceFacade::actionExpiresIn7Days($toExpire->id);
        }

        return $expireIn7DaysActions;
    }


    /**
     * Get the not available volunteers.
     * If the end date of the status is equal to now,
     * then set the volunteer to available again
     */
    public function notAvailableVolunteers() {

        //TODO: refactor asap, fix query scopes
        $notAvailableVolunteers = Volunteer::notAvailable();
        $notAvailableVolunteers->load('statusDuration.status');
        $count = 0;

        foreach ($notAvailableVolunteers as $volunteer) {

            if(sizeof($volunteer->statusDuration)>0) {

                $now = \Carbon::now();
                $to = \Carbon::createFromFormat('d/m/Y', $volunteer->statusDuration[0]->to_date);

                //set as available again
                 if ($now->diffInDays($to) == 1) {
                     VolunteerServiceFacade::setVolunteerToAvailable($volunteer->statusDuration[0]->id);
                     $count++;
                 }
            }
        }

        return $count;
    }


}
