<?php namespace App\Services;


use App\Models\Action;
use App\Models\Volunteer;
use App\Models\VolunteerWorkDateHistory;
use App\Services\Facades\VolunteerService;

class WorkDateService
{

    /**
     * Delete a workDate and dissociate any volunteers attached
     *
     * @param $workDate
     */
    public function delete($workDate)
    {
        $action = Action::find(\Request::get('action_id'));

        //remove the volunteers from the action
        foreach ($workDate->volunteers as $volunteer) {
            $volunteer->workDates()->detach();

           // if($volunteer->action)

            VolunteerService::removeFromAction($volunteer, $action);
        }

        $workDate->subtask()->dissociate();
        $workDate->ctaVolunteers()->detach();
        $workDate->delete();

        return;
    }

    /**
     * Add the volunteers to a certain action
     *
     * @param $volunteers
     * @param $workDateId
     * @param $action
     */
    public function addVolunteersToAction($volunteers, $workDateId, $action)
    {
        //add the volunteers to the action
        foreach ($volunteers as $volunteer) {
            $volunteer = Volunteer::find($volunteer);
            WorkDateService::addWorkDateHistory($volunteer->id, $workDateId);

            //first check that the user is not already assigned to an action
            $flag = false;
            foreach ($volunteer->actions as $a) {
                if ($a->id == $action->id)
                    $flag = true;
            }
            if (!$flag)
                VolunteerService::addToAction($volunteer, $action);
        }

        return;
    }

    /**
     * Add an entry to the history table
     *
     * @param $volunteerId
     * @param $workDateId
     */
    public function addWorkDateHistory($volunteerId, $workDateId)
    {
        $workDateHistory = VolunteerWorkDateHistory::where('volunteer_id', $volunteerId)
            ->where('work_date_id', $workDateId)->first();

        if ($workDateHistory == null)
            VolunteerWorkDateHistory::create([
                'volunteer_id' => $volunteerId,
                'work_date_id' => $workDateId
            ]);

        return;
    }

}
