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
            ShiftServiceFacade::delete($shift);
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

        if (\Request::has('assignToSubtask') && \Request::get('assignToSubtask') == 'user'
            && \Request::has('subtaskUserSelect') && \Request::get('subtaskUserSelect') != 0
        ) {
            $subtask->users()->sync([\Request::get('subtaskUserSelect')]);
            $subtask->volunteers()->detach();
        }
        else if(sizeof($subtask->users())>0){
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

        if (\Request::has('assignToSubtask') && \Request::get('assignToSubtask') == 'volunteer'
            && \Request::has('subtaskVolunteerSelect') && \Request::get('subtaskVolunteerSelect') != 0
        ) {
            $subtask->volunteers()->sync([\Request::get('subtaskVolunteerSelect')]);
            $subtask->users()->sync([]);
        }
        else if(sizeof($subtask->volunteers())>0){
            $subtask->volunteers()->detach();
        }

        return;
    }

}
