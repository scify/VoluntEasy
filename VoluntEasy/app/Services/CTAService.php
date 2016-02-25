<?php namespace App\Services;


class CTAService {


    public function getPublicSubtasks($action) {

        $publicSubtasks = $action->publicAction->subtasks()->lists('subtask_id')->toArray();

        $final = [];

        foreach ($action->tasks as $task) {
            $subtasks = array_merge($task->todoSubtasks, $task->doingSubtasks);
            $subtasks = array_merge($subtasks, $task->doneSubtasks);

            foreach ($subtasks as $subtask) {
                if (in_array($subtask->id, $publicSubtasks)) {

                    foreach ($action->publicAction->subtasks as $publicSubtask) {
                        if ($publicSubtask->pivot->subtask_id == $subtask->id) {
                            $final[$subtask->id] =$publicSubtask->description;
                        }
                   }
                }
            }
        }

        return $final;
    }
}
