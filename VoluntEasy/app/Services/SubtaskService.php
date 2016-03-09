<?php namespace App\Services;


use App\Models\CTA\PublicActionSubTask;
use App\Services\Facades\WorkDateService as WorkDateServiceFacade;

class SubtaskService
{


    /**
     * Delete a subtask and remove all associated rows
     *
     * @param $subTask
     */
    public function delete($subTask){

        //remove the associated workDates
        foreach ($subTask->workDates as $workDate) {
            WorkDateServiceFacade::delete($workDate);
        }

        //remove the public subtasks
        PublicActionSubTask::where('subtask_id', $subTask->id)->delete();

        $subTask->checklist()->delete();
        $subTask->delete();

        return;
    }

}
