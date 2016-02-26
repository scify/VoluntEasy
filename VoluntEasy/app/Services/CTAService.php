<?php namespace App\Services;


class CTAService {


    public function getPublicSubtasks($action) {

        $final = [];

        foreach ($action->tasks as $task) {
            $subtasks = array_merge($task->todoSubtasks, $task->doingSubtasks);
            $subtasks = array_merge($subtasks, $task->doneSubtasks);

            foreach ($subtasks as $subtask) {
                foreach ($action->publicAction->subtasks as $public) {
                    if ($public->subtask_id == $subtask->id) {
                        $final[$subtask->id] = $public->description;
                    }
                }
            }
        }

        return $final;
    }
}
