<?php

namespace App\Services;

use App\Models\Action;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Rating\ActionRating;
use App\Models\Volunteer;
use App\Services\Volunteers\VolunteerAssignment;
use Illuminate\Support\Str;

class CronService
{
    private NotificationService $notificationService;

    private VolunteerAssignment $volunteerAssignment;

    public function __construct(VolunteerAssignment $volunteerAssignment, NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->volunteerAssignment = $volunteerAssignment;
    }

    public function expiredActions()
    {

        $expiredActions = Action::expiredYesterday()->with('volunteers', 'users', 'tasks.shifts', 'tasks.subtasks.shifts')->get();

        foreach ($expiredActions as $expired) {

            // send emails to all action users to rate volunteers
            foreach ($expired->users as $user) {

                $token = Str::random(30);
                $url = config('app.url').'/rateVolunteers/'.$token;
                // create a new action rating
                // with the action id, the email and the token
                $actionRating = new ActionRating([
                    'action_id' => $expired->id,
                    'user_id' => $user->id,
                    'token' => $token,
                ]);

                $actionRating->save();

                // then send an email to the person responsible for the action

                \Mail::send('app_emails.rate_volunteers', ['action' => $expired, 'token' => $token, 'url' => $url], function ($message) use ($user) {
                    $message->to($user->email, $user->name.' '.$user->last_name)->subject('['.trans('default.title').'] '.trans('entities/ratings.volunteerRatingHalf'));
                });
            }

            // the shifts of the expired action
            $taskShiftIds = $expired->tasks->flatMap(fn ($task) => $task->shifts->pluck('id'))->all();
            $subtaskShiftIds = $expired->tasks
                ->flatMap(fn ($task) => $task->subtasks->flatMap(fn ($subtask) => $subtask->shifts->pluck('id')))
                ->all();

            // for all volunteers, set their unit status to available
            // and remove them from the shifts of the expired action
            foreach ($expired->volunteers as $volunteer) {
                $statusId = VolunteerStatus::available();
                $this->volunteerAssignment->changeUnitStatus($volunteer->id, $expired->unit_id, $statusId);

                if ($taskShiftIds !== []) {
                    $volunteer->taskShifts()->detach($taskShiftIds);
                }
                if ($subtaskShiftIds !== []) {
                    $volunteer->subtaskShifts()->detach($subtaskShiftIds);
                }
            }

            if (count($expired->volunteers) > 0) {
                // detach all volunteers
                $expired->volunteers()->detach();
            }

            // notify users that action has expired
            $this->notificationService->actionExpired($expired->id);
        }

        return $expiredActions;
    }

    /**
     * Notify users about to expire actions
     */
    public function toExpireActions()
    {

        // get all the active actions
        $actives = Action::active()->get();
        $count = 0;

        foreach ($actives as $action) {

            // get the start, end dates in Carbon format
            $startDate = \Carbon::createFromFormat('d/m/Y', $action->start_date);
            $endDate = \Carbon::createFromFormat('d/m/Y', $action->end_date);

            // calculate the duration of the action and get the half of it
            // since we want to notify the user when the action is halfway
            $durationHalf = intval((int) $endDate->diffInDays($startDate, true) / 2);

            $now = \Carbon::now();

            // if the time is right (that is if today is the same day as
            // start_date + durationHalf, notify the users
            if ((int) $startDate->addDays($durationHalf)->diffInDays($now, true) == 0) {
                $this->notificationService->actionWillExpire($action->id);
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
    public function notAvailableVolunteers()
    {

        $notAvailableVolunteers = Volunteer::notAvailable()->get();
        $count = 0;

        if (count($notAvailableVolunteers) > 0) {
            $notAvailableVolunteers->load('statusDuration.status');

            foreach ($notAvailableVolunteers as $volunteer) {

                if (count($volunteer->statusDuration) > 0) {

                    $now = \Carbon::now();
                    $to = \Carbon::createFromFormat('d/m/Y', $volunteer->statusDuration[0]->to_date);

                    // set as available again
                    if ((int) $now->diffInDays($to, true) == 1) {
                        $this->volunteerAssignment->setVolunteerToAvailable($volunteer->statusDuration[0]->id);
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
    public function expiredContracts()
    {

        $expiredContracts = Volunteer::expiredContract()->with('units.users')->get();

        foreach ($expiredContracts as $volunteer) {
            $this->notificationService->volunteerContractExpired($volunteer);
        }

    }

    /**
     * Get the contracts about to expire and notify users
     */
    public function toExpireContracts()
    {

        $toExpireContracts = Volunteer::toExpireContract()->with('units.users')->get();

        foreach ($toExpireContracts as $volunteer) {
            $this->notificationService->volunteerContractToExpire($volunteer);
        }

    }
}
