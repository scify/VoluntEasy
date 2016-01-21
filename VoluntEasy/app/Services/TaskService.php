<?php namespace App\Services;


class TaskService {

    /**
     * For a certain action, return the subtasks per status
     * (to do, doing, done)
     *
     * @param $action
     */
    public function subtasksPerStatus($action) {

        foreach ($action->tasks as $task) {

            $todoSubtasks = [];
            $doingSubtasks = [];
            $doneSubtasks = [];

            foreach ($task->subtasks as $subtask) {

                if ($subtask->status_id == "1")
                    array_push($todoSubtasks, $subtask);
                else if ($subtask->status_id == "2")
                    array_push($todoSubtasks, $subtask);
                else
                    array_push($todoSubtasks, $subtask);

            }
            unset($task->subtasks);
            $task->todoSubtasks = $todoSubtasks;
            $task->doingSubtasks = $doingSubtasks;
            $task->doneSubtasks = $doneSubtasks;
        }

        return $action;

    }
}
