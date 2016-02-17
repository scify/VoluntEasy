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

            $today = \Carbon::today();

            foreach ($task->subtasks as $subtask) {
                $subtask->expires = 'null';
                if ($subtask->due_date != null) {
                    $dueDate = \Carbon::createFromFormat('d/m/Y', $subtask->due_date);
                    $dueDate->hour = 0;
                    $dueDate->minute = 0;
                    $dueDate->second = 0;
                    $subtask->expires = $today->diffInDays($dueDate, false);
                }

                if ($subtask->status_id == 1)
                    array_push($todoSubtasks, $subtask);
                else if ($subtask->status_id == 2)
                    array_push($doingSubtasks, $subtask);
                else
                    array_push($doneSubtasks, $subtask);
            }

            unset($task->subtasks);
            $task->todoSubtasks = $todoSubtasks;
            $task->doingSubtasks = $doingSubtasks;
            $task->doneSubtasks = $doneSubtasks;

            $task->expires = null;
            if ($task->due_date != null) {
                $dueDate = \Carbon::createFromFormat('d/m/Y', $task->due_date);
                $dueDate->hour = 0;
                $dueDate->minute = 0;
                $dueDate->second = 0;
                $task->expires = $today->diffInDays($dueDate, false);
            }
        }

        return $action;

    }
}
