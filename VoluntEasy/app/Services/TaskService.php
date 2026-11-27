<?php

namespace App\Services;

use App\Models\Action;

class TaskService
{
    /** Subtask status ids. */
    private const TODO = 1;

    private const DOING = 2;

    /** Order of the task statuses on the task board. */
    private const STATUS_ORDER = ['todo' => 1, 'doing' => 2, 'done' => 3];

    /**
     * Prepare the tasks of an action for the task board: split each task's
     * subtasks by status (to do, doing, done), add due dates and counts,
     * sort the tasks by status and calculate the total volunteer sum.
     *
     * @param  Action  $action
     * @return Action
     */
    public function prepareTasks($action)
    {
        $volunteerSum = 0;

        foreach ($action->tasks as $task) {
            $subtasks = ['todo' => [], 'doing' => [], 'done' => []];

            foreach ($task->subtasks as $subtask) {
                $this->setDueDate($subtask);
                $subtask->volunteerSum = $subtask->shifts->sum('volunteer_sum');
                $subtask->ctaVolunteersCount = $subtask->shifts->sum(fn ($shift) => count($shift->ctaVolunteers));
                $subtask->completedChecklistItems = $this->completedItems($subtask->checklist);

                $subtasks[$this->subtaskStatus($subtask)][] = $subtask;
                $volunteerSum += $subtask->volunteerSum;
            }

            unset($task->subtasks);
            $task->todoSubtasks = $subtasks['todo'];
            $task->doingSubtasks = $subtasks['doing'];
            $task->doneSubtasks = $subtasks['done'];

            $this->setDueDate($task);
            // "status" is also a relation name, so set the attribute explicitly
            $status = $this->statusFromCounts(count($subtasks['todo']), count($subtasks['doing']), count($subtasks['done']));
            $task->setAttribute('status', $status);
            $task->statusOrderId = $status === null ? 0 : self::STATUS_ORDER[$status];
            $task->completedChecklistItems = $this->completedItems($task->checklist);
        }

        // sort tasks by status (the board works with plain objects)
        $tasks = json_decode($action->tasks);
        usort($tasks, fn ($a, $b) => $a->statusOrderId <=> $b->statusOrderId);

        $action->unsetRelation('tasks');
        $action->setAttribute('tasks', json_decode(json_encode($tasks)));
        $action->volunteerTaskSum = $volunteerSum;

        return $action;
    }

    /**
     * Find the task status from the status of its subtasks.
     *
     * @return string|null "todo", "doing", "done" or null if the task has no subtasks
     */
    public function taskStatus($task)
    {
        $counts = ['todo' => 0, 'doing' => 0, 'done' => 0];
        foreach ($task->subtasks as $subtask) {
            $counts[$this->subtaskStatus($subtask)]++;
        }

        return $this->statusFromCounts($counts['todo'], $counts['doing'], $counts['done']);
    }

    /**
     * A task is "doing" if a subtask is in progress, otherwise "todo" while
     * a subtask is still to do, otherwise "done".
     */
    private function statusFromCounts(int $todo, int $doing, int $done): ?string
    {
        return match (true) {
            $doing > 0 => 'doing',
            $todo > 0 => 'todo',
            $done > 0 => 'done',
            default => null,
        };
    }

    private function subtaskStatus(object $subtask): string
    {
        return match ((int) $subtask->status_id) {
            self::TODO => 'todo',
            self::DOING => 'doing',
            default => 'done',
        };
    }

    /**
     * Set "expires" (days from today until the due date, negative when late,
     * the string "null" without a due date) and "dueDateMin" (28/01, or
     * 28/01/17 when the due date is not within a year).
     */
    private function setDueDate(object $item): void
    {
        $item->expires = 'null';
        $item->dueDateMin = null;
        if ($item->due_date == null) {
            return;
        }

        $dueDate = \Carbon::createFromFormat('d/m/Y', $item->due_date)->startOfDay();
        $item->expires = (int) \Carbon::today()->diffInDays($dueDate, false);
        $item->dueDateMin = $dueDate->format((int) \Carbon::now()->diffInYears($dueDate, true) == 0 ? 'd/m' : 'd/m/y');
    }

    /** @param iterable<object> $checklist */
    private function completedItems(iterable $checklist): int
    {
        $completed = 0;
        foreach ($checklist as $item) {
            if ($item->isComplete) {
                $completed++;
            }
        }

        return $completed;
    }

    /**
     * Save the user that may be assigned to the task
     */
    public function syncUsers($task)
    {

        if (\Request::filled('assignToTask') && \Request::get('assignToTask') == 'user'
            && \Request::filled('taskUserSelect') && \Request::get('taskUserSelect') != 0
        ) {
            $task->users()->sync([\Request::get('taskUserSelect')]);
            $task->volunteers()->detach();
            // $task->volunteers()->sync([]);
        } else {
            $task->users()->detach();
        }

    }

    /**
     * Save the volunteer that may be assigned to the task
     */
    public function syncVolunteers($task)
    {

        if (\Request::filled('assignToTask') && \Request::get('assignToTask') == 'volunteer'
            && \Request::filled('taskVolunteerSelect') && \Request::get('taskVolunteerSelect') != 0
        ) {
            $task->volunteers()->sync([\Request::get('taskVolunteerSelect')]);
            $task->users()->sync([]);
        } else {
            $task->volunteers()->detach();
        }

    }
}
