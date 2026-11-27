<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\Task;
use App\Models\ActionTasks\VolunteerTask;
class TaskController extends Controller {

    private \App\Services\SubtaskService $subtaskService;
    private \App\Services\TaskService $taskService;
    private \App\Services\VolunteerService $volunteerService;

    public function __construct(\App\Services\SubtaskService $subtaskService, \App\Services\TaskService $taskService, \App\Services\VolunteerService $volunteerService) {
        $this->subtaskService = $subtaskService;
        $this->taskService = $taskService;
        $this->volunteerService = $volunteerService;
        $this->middleware('auth');
    }

    /**
     * View a certain task
     *
     * @param $id
     * @return mixed
     */
    public function show($id) {
        $task = Task::with('action', 'users', 'volunteers', 'checklist.createdBy', 'checklist.updatedBy', 'shifts.volunteers')->findOrFail($id);
        $task->unitVolunteers = $this->volunteerService->getAvailableUnitVolunteers($task->action->unit_id);

        return $task;
    }

    /**
     * Store a new resource
     */
    public function store() {

        if (!\Request::filled('status_id'))
            $status_id = Status::todo();
        else
            $status_id = \Request::get('status_id');

        if (\Request::filled('due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('due_date'));
        else
            $due_date = null;

        $task = new Task([
            'name' => \Request::get('name'),
            'description' => \Request::get('description'),
            'action_id' => \Request::get('actionId'),
            'priority' => \Request::get('priority'),
            'status_id' => $status_id,
            'due_date' => $due_date
        ]);

        $task->save();

        $this->taskService->syncUsers($task);
        $this->taskService->syncVolunteers($task);

        return $task;
    }

    /**
     * Update a resource
     */
    public function update() {

        $task = Task::findOrFail(\Request::get('taskId'));

        if (!\Request::filled('status_id'))
            $status_id = Status::todo();
        else
            $status_id = \Request::get('status_id');

        if (\Request::filled('due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('due_date'));
        else
            $due_date = null;

        $task->update([
            'name' => \Request::get('name'),
            'description' => \Request::get('description'),
            'action_id' => \Request::get('actionId'),
            'priority' => \Request::get('priority'),
            'status_id' => $status_id,
            'due_date' => $due_date
        ]);

        $this->taskService->syncUsers($task);
        $this->taskService->syncVolunteers($task);

        return \Redirect::route('action/one', ['id' => $task->action_id]);
    }

    /**
     * Delete a resource
     */
    public function destroy($id) {

        $task = Task::with('subtasks.shifts.volunteers')->findOrFail($id);

        foreach ($task->subtasks as $subtask) {
            $this->subtaskService->delete($subtask);
        }

        \Session::flash('flash_message', trans('entities/tasks.deleted'));
        \Session::flash('flash_type', 'alert-success');

        $task->delete();

        return;
    }

    public function addVolunteer($id) {

        $volunteerTask = new VolunteerTask([
            'volunteers_id' => \Request::get('volunteer_id'),
            'task_id' => \Request::get('task_id'),
            'status_id' => \Request::get('status_id'),
            'job_descr' => \Request::get('job_descr'),
        ]);
    }

}
