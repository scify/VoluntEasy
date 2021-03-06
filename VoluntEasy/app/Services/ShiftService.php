<?php namespace App\Services;


use App\Models\Action;
use App\Models\Volunteer;
use App\Models\VolunteerTaskShiftHistory;
use App\Models\VolunteerSubtaskShiftHistory;
use App\Services\Facades\VolunteerService as VolunteerServiceFacade;

class ShiftService
{

    /**
     * Delete a shift and dissociate any volunteers attached
     *
     * @param $shift
     */
    public function deleteTaskShift($shift)
    {
        $action = Action::find(\Request::get('action_id'));

        //remove the volunteers from the action
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->shifts()->detach([$shift->id]);
            //VolunteerServiceFacade::removeFromAction($volunteer, $action);
        }

        foreach($shift->ctaVolunteers as $cta){
            $cta->delete();
        }

        $shift->task()->dissociate();
        $shift->delete();

        return;
    }

    public function deleteSubtaskShift($shift)
    {
        $action = Action::find(\Request::get('action_id'));

        //remove the volunteers from the action
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->shifts()->detach([$shift->id]);
            //VolunteerServiceFacade::removeFromAction($volunteer, $action);
        }

        foreach($shift->ctaVolunteers as $cta){
            $cta->delete();
        }

        $shift->subtask()->dissociate();
        $shift->delete();

        return;
    }

    /**
     * Add the volunteers to a certain action
     *
     * @param $volunteers
     * @param $shiftId
     * @param $action
     */
    public function addVolunteersToTask($volunteers, $shiftId, $action)
    {
        //add the volunteers to the action
        foreach ($volunteers as $volunteer) {
            $volunteer = Volunteer::find($volunteer);
            $this->addTaskShiftHistory($volunteer->id, $shiftId);

            //first check that the user is not already assigned to an action
            $flag = false;
            foreach ($volunteer->actions as $a) {
                if ($a->id == $action->id)
                    $flag = true;
            }
            if (!$flag)
                VolunteerServiceFacade::addToAction($volunteer, $action);
        }

        return;
    }

    /**
     * Add the volunteers to a certain action
     *
     * @param $volunteers
     * @param $shiftId
     * @param $action
     */
    public function addVolunteersToSubTask($volunteers, $shiftId, $action)
    {
        //add the volunteers to the action
        foreach ($volunteers as $volunteer) {
            $volunteer = Volunteer::find($volunteer);
            $this->addSubtaskShiftHistory($volunteer->id, $shiftId);

            //first check that the user is not already assigned to an action
            $flag = false;
            foreach ($volunteer->actions as $a) {
                if ($a->id == $action->id)
                    $flag = true;
            }
            if (!$flag)
                VolunteerServiceFacade::addToAction($volunteer, $action);
        }

        return;
    }

    /**
     * Add an entry to the history table
     *
     * @param $volunteerId
     * @param $shiftId
     */
    public function addTaskShiftHistory($volunteerId, $shiftId)
    {
        $shiftHistory = VolunteerTaskShiftHistory::where('volunteer_id', $volunteerId)
            ->where('shift_id', $shiftId)->first();

        if ($shiftHistory == null)
            VolunteerTaskShiftHistory::create([
                'volunteer_id' => $volunteerId,
                'shift_id' => $shiftId
            ]);

        return;
    }

    /**
     * Add an entry to the history table
     *
     * @param $volunteerId
     * @param $shiftId
     */
    public function addSubtaskShiftHistory($volunteerId, $shiftId)
    {
        $shiftHistory = VolunteerSubtaskShiftHistory::where('volunteer_id', $volunteerId)
            ->where('shift_id', $shiftId)->first();

        if ($shiftHistory == null)
            VolunteerSubtaskShiftHistory::create([
                'volunteer_id' => $volunteerId,
                'shift_id' => $shiftId
            ]);

        return;
    }
}
