<?php namespace App\Services;


class TaskService {

    /**
     * For a certain action, return the subtasks per status
     * (to do, doing, done).
     * Calculate the total volunteer sum
     * Sort tasks by status
     *
     * @param $action
     */
    public function prepareTasks($action) {

        $volunteerSum = 0;

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

                //calculate the total volunteer sum
                $subtaskVolunteers = 0;
                foreach ($subtask->workDates as $date) {
                    foreach ($date->hours as $hour) {
                        $volunteerSum += $hour->volunteer_sum;
                        $subtaskVolunteers += $hour->volunteer_sum;
                    }
                }

                $subtask->volunteerSum = $subtaskVolunteers;
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

            $task->status = null;
            $task->statusOrderId = 0;
            if (sizeof($task->todoSubtasks) > 0 && sizeof($task->doingSubtasks) == 0 && sizeof($task->doneSubtasks) == 0) {
                $task->status = "todo";
                $task->statusOrderId = 1;
            } else if (sizeof($task->doneSubtasks) > 0 && sizeof($task->doingSubtasks) == 0 && sizeof($task->todoSubtasks) == 0) {
                $task->status = "done";
                $task->statusOrderId = 3;
            } else if (sizeof($task->doingSubtasks) > 0) {
                $task->status = "doing";
                $task->statusOrderId = 2;
            }
        }

        //sort tasks by status
        $tasks = json_decode($action->tasks);

        usort($tasks, function ($a, $b) {
            if ($a->statusOrderId > $b->statusOrderId) {
                return 1;
            } else if ($a->statusOrderId < $b->statusOrderId) {
                return -1;
            } else {
                return 0;
            }
        });

        unset($action->tasks);
        $action->tasks = json_decode(json_encode($tasks));
        $action->volunteerSum = $volunteerSum;

        return $action;
    }
}
