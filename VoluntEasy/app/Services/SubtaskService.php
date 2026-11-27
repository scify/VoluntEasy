<?php

namespace App\Services;

use App\Models\CTA\PublicActionSubTask;

class SubtaskService
{
    private ShiftService $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    /**
     * Delete a subtask and remove all associated rows
     */
    public function delete($subTask)
    {

        // remove the associated shifts
        foreach ($subTask->shifts as $shift) {
            $this->shiftService->deleteSubtaskShift($shift);
        }

        // remove the public subtasks
        PublicActionSubTask::where('subtask_id', $subTask->id)->delete();

        $subTask->checklist()->delete();
        $subTask->delete();

    }

    /**
     * Save the user that may be assigned to the subtask
     */
    public function syncUsers($subtask)
    {

        if (\Request::filled('assignToSubtask') && \Request::get('assignToSubtask') == 'user'
            && \Request::filled('subtaskUserSelect') && \Request::get('subtaskUserSelect') != 0
        ) {
            $subtask->users()->sync([\Request::get('subtaskUserSelect')]);
            $subtask->volunteers()->detach();
        } else {
            $subtask->users()->detach();
        }

    }

    /**
     * Save the volunteer that may be assigned to the subtask
     */
    public function syncVolunteers($subtask)
    {

        if (\Request::filled('assignToSubtask') && \Request::get('assignToSubtask') == 'volunteer'
            && \Request::filled('subtaskVolunteerSelect') && \Request::get('subtaskVolunteerSelect') != 0
        ) {
            $subtask->volunteers()->sync([\Request::get('subtaskVolunteerSelect')]);
            $subtask->users()->sync([]);
        } else {
            $subtask->volunteers()->detach();
        }

    }
}
