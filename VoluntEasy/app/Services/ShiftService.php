<?php

namespace App\Services;

use App\Models\Action;
use App\Models\ActionTasks\SubtaskShift;
use App\Models\ActionTasks\TaskShift;
use App\Models\Volunteer;
use App\Models\VolunteerSubtaskShiftHistory;
use App\Models\VolunteerTaskShiftHistory;
use App\Services\Volunteers\VolunteerAssignment;

class ShiftService
{
    public function __construct(private readonly VolunteerAssignment $volunteerAssignment) {}

    /**
     * Delete a shift and dissociate any volunteers attached
     */
    public function deleteTaskShift(TaskShift $shift)
    {
        // remove the volunteers from the shift
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->taskShifts()->detach([$shift->id]);
        }

        foreach ($shift->ctaVolunteers as $cta) {
            $cta->delete();
        }

        $shift->task()->dissociate();
        $shift->delete();

    }

    public function deleteSubtaskShift(SubtaskShift $shift)
    {
        // remove the volunteers from the shift
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->subtaskShifts()->detach([$shift->id]);
        }

        foreach ($shift->ctaVolunteers as $cta) {
            $cta->delete();
        }

        $shift->subtask()->dissociate();
        $shift->delete();

    }

    /**
     * Add the volunteers to a certain action
     */
    public function addVolunteersToTask($volunteers, $shiftId, $action)
    {
        // add the volunteers to the action
        foreach ($volunteers as $volunteer) {
            $volunteer = Volunteer::find($volunteer);
            $this->addTaskShiftHistory($volunteer->id, $shiftId);

            // first check that the user is not already assigned to an action
            $flag = false;
            foreach ($volunteer->actions as $a) {
                if ($a->id == $action->id) {
                    $flag = true;
                }
            }
            if (! $flag) {
                $this->volunteerAssignment->addToAction($volunteer, $action);
            }
        }

    }

    /**
     * Add the volunteers to a certain action
     */
    public function addVolunteersToSubTask($volunteers, $shiftId, $action)
    {
        // add the volunteers to the action
        foreach ($volunteers as $volunteer) {
            $volunteer = Volunteer::find($volunteer);
            $this->addSubtaskShiftHistory($volunteer->id, $shiftId);

            // first check that the user is not already assigned to an action
            $flag = false;
            foreach ($volunteer->actions as $a) {
                if ($a->id == $action->id) {
                    $flag = true;
                }
            }
            if (! $flag) {
                $this->volunteerAssignment->addToAction($volunteer, $action);
            }
        }

    }

    /**
     * Add an entry to the history table
     */
    public function addTaskShiftHistory($volunteerId, $shiftId)
    {
        $shiftHistory = VolunteerTaskShiftHistory::where('volunteer_id', $volunteerId)
            ->where('shift_id', $shiftId)->first();

        if ($shiftHistory == null) {
            VolunteerTaskShiftHistory::create([
                'volunteer_id' => $volunteerId,
                'shift_id' => $shiftId,
            ]);
        }

    }

    /**
     * Add an entry to the history table
     */
    public function addSubtaskShiftHistory($volunteerId, $shiftId)
    {
        $shiftHistory = VolunteerSubtaskShiftHistory::where('volunteer_id', $volunteerId)
            ->where('shift_id', $shiftId)->first();

        if ($shiftHistory == null) {
            VolunteerSubtaskShiftHistory::create([
                'volunteer_id' => $volunteerId,
                'shift_id' => $shiftId,
            ]);
        }

    }
}
