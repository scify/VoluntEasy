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
                foreach ($subtask->shifts as $shift) {
                    $volunteerSum += $shift->volunteer_sum;
                    $subtaskVolunteers += $shift->volunteer_sum;

                }

                $subtask->volunteerSum = $subtaskVolunteers;

                $ctaVolunteers = 0;
                foreach ($subtask->shifts as $shift) {
                    $ctaVolunteers += sizeof($shift->ctaVolunteers);
                }
                $subtask->ctaVolunteersCount = $ctaVolunteers;

                //count the complete checlist items
                $completed = 0;
                foreach($subtask->checklist as $item){
                    if($item->isComplete)
                        $completed = $completed + 1;
                }
                $subtask->completedChecklistItems = $completed;

                //set the due date in a nicer format, ie 28/01
                $tmpDueDate = \Carbon::createFromFormat('d/m/Y', $subtask->due_date);
                $subtask->dueDateMin = $tmpDueDate->format('d/m');

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
        $action->volunteerTaskSum = $volunteerSum;

        return $action;
    }

    /**
     * Find the task status
     *
     * @param $task
     * @return mixed
     */
    public function taskStatus($task) {

        $todoSubtasks = 0;
        $doingSubtasks = 0;
        $doneSubtasks = 0;

        foreach ($task->subtasks as $subtask) {
            if ($subtask->status_id == "1")
                $todoSubtasks++;
            else if ($subtask->status_id == "2")
                $doingSubtasks++;
            else
                $doneSubtasks++;
        }

        $status = null;
        if ($todoSubtasks > 0 && $doingSubtasks == 0) {
            $status = "todo";
        } else if ($doneSubtasks > 0 && $doingSubtasks == 0 && $todoSubtasks == 0) {
            $status = "done";
        } else if ($doingSubtasks > 0) {
            $status = "doing";
        }

        return $status;
    }

    /**
     * Save the user that may be assigned to the task
     *
     * @param $task
     */
    public function syncUsers($task) {

        if (\Request::has('assignToTask') && \Request::get('assignToTask') == 'user'
            && \Request::has('taskUserSelect') && \Request::get('taskUserSelect') != 0
        ) {
            $task->users()->sync([\Request::get('taskUserSelect')]);
            $task->volunteers()->detach();
            //$task->volunteers()->sync([]);
        }
        else if(sizeof($task->users())>0){
            $task->users()->detach();
        }

        return;
    }

    /**
     * Save the volunteer that may be assigned to the task
     *
     * @param $task
     */
    public function syncVolunteers($task) {

        if (\Request::has('assignToTask') && \Request::get('assignToTask') == 'volunteer'
            && \Request::has('taskVolunteerSelect') && \Request::get('taskVolunteerSelect') != 0
        ) {
            $task->volunteers()->sync([\Request::get('taskVolunteerSelect')]);
            $task->users()->sync([]);
        }
        else if(sizeof($task->volunteers())>0){
            $task->volunteers()->detach();
        }

        return;
    }
}
