<?php namespace App\Services;

use App\Models\CTA\PublicActionSubTask;
use App\Services\Facades\ShiftService as ShiftServiceFacade;

class SubtaskService
{

    /**
     * Delete a subtask and remove all associated rows
     *
     * @param $subTask
     */
    public function delete($subTask){

        //remove the associated shifts
        foreach ($subTask->shifts as $shift) {
            ShiftServiceFacade::deleteSubtaskShift($shift);
        }

        //remove the public subtasks
        PublicActionSubTask::where('subtask_id', $subTask->id)->delete();

        $subTask->checklist()->delete();
        $subTask->delete();

        return;
    }

    /**
     * Save the user that may be assigned to the subtask
     *
     * @param $subtask
     */
    public function syncUsers($subtask) {

        if (\Request::filled('assignToSubtask') && \Request::get('assignToSubtask') == 'user'
            && \Request::filled('subtaskUserSelect') && \Request::get('subtaskUserSelect') != 0
        ) {
            $subtask->users()->sync([\Request::get('subtaskUserSelect')]);
            $subtask->volunteers()->detach();
        }
        else {
            $subtask->users()->detach();
        }

        return;
    }

    /**
     * Save the volunteer that may be assigned to the subtask
     *
     * @param $subtask
     */
    public function syncVolunteers($subtask) {

        if (\Request::filled('assignToSubtask') && \Request::get('assignToSubtask') == 'volunteer'
            && \Request::filled('subtaskVolunteerSelect') && \Request::get('subtaskVolunteerSelect') != 0
        ) {
            $subtask->volunteers()->sync([\Request::get('subtaskVolunteerSelect')]);
            $subtask->users()->sync([]);
        }
        else {
            $subtask->volunteers()->detach();
        }

        return;
    }

}
