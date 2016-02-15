<?php namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
use App\Models\ActionTasks\Task;
use App\Models\ActionTasks\VolunteerTask;
use App\Models\Unit;

class TaskController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * View a certain task
     *
     * @param $id
     * @return mixed
     */
    public function getTask($id) {
        $task = Task::findOrFail($id);

        return $task;
    }

    /**
     * Show create form
     */
    public function create($actionId) {
        $volunteers = $this->getAvailableVolunteers($actionId);

        return view('main.tasks.create', compact('actionId', 'volunteers'));
    }

    /**
     * Store a new resource
     */
    public function store(TaskRequest $request) {

        $isComplete = false;
        if ($request['status'] == 'complete')
            $isComplete = true;

        $task = new Task([
            'name' => $request['name'],
            'description' => $request['description'],
            'action_id' => $request['actionId'],
            'isComplete' => $isComplete,
            'priority' => $request['priority']
        ]);

        $task->save();

        return $task;
    }

    /**
     * Show edit form
     */
    public function edit($taskId) {
        $task = Task::findOrFail($taskId);
        $taskStatuses = Status::all();

        $unit = $this->getAvailableVolunteers($task->action_id);
        $volunteers = $unit['volunteers']->lists('fullName', 'id');
        $unitName = $unit['unit_name'];

        return view('main.tasks.edit', compact('task', 'volunteers', 'unitName', 'taskStatuses'));
    }


    /**
     * Update a resource
     */
    public function update(TaskRequest $request) {

        $task = Task::findOrFail($request['id']);

        $isComplete = false;
        if ($request['status'] == 'complete')
            $isComplete = true;

        $task->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'action_id' => $request['actionId'],
            'isComplete' => $isComplete
        ]);

        return \Redirect::route('action/one', ['id' => $request['actionId']]);
    }

    /**
     * Delete a resource
     */
    public function destroy($id) {

        $task = Task::with('subtasks')->findOrFail($id);

        if (sizeof($task->subtasks) > 0) {
            \Session::flash('flash_message', 'Το task περιέχει subtasks και δεν μπορεί να διαγραφεί.');
            \Session::flash('flash_type', 'alert-danger');
            return;
        }

        \Session::flash('flash_message', 'Η δράση διαγράφηκε.');
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

    /**
     * View a certain subtask
     *
     * @param $id
     * @return mixed
     */
    public function getSubtask($id) {
        $subTask = SubTask::findOrFail($id);

        return $subTask;
    }

    /**
     * Store a subtask
     */
    public function storeSubTask() {

        $todo = Status::todo();

        $subTask = new SubTask([
            'name' => \Request::get('subtask-name'),
            'description' => \Request::get('subtask-description'),
            'priority' => \Request::get('subtask-priorities'),
            'task_id' => \Request::get('taskId'),
            'action_id' => \Request::get('actionId'),
            'status_id' => $todo
        ]);

        $subTask->save();

        return;
    }

    /**
     * Update a subtask
     */
    public function updateSubTask() {

        $subTask = SubTask::find(\Request::get('subTaskId'));

        $subTask->update([
            'name' => \Request::get('subtask-name'),
            'description' => \Request::get('subtask-description'),
            'priority' => \Request::get('subtask-priorities')]);

        return;
    }

    /**
     * Update a subtask's status
     */
    public function updateSubTaskStatus() {

        $subTask = SubTask::find(\Request::get('subTaskId'));

        $status = Status::where('description', \Request::get('status'))->first()->id;
        $subTask->update(['status_id' => $status]);

        return;
    }


    /**
     * Delete a subtask
     *
     * @param $id
     * @throws \Exception
     */
    public function deleteSubTask($id) {

        $subTask = SubTask::with('volunteers')->find($id);

        if (sizeof($subTask->volunteers) > 0) {
            \Session::flash('flash_message', 'Το subtask περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            \Session::flash('flash_type', 'alert-danger');
            return;
        }

        \Session::flash('flash_message', 'Το subtask διαγράφηκε.');
        \Session::flash('flash_type', 'alert-success');

        $subTask->delete();

        return;
    }

    /**
     * For a certain action, get only the volunteers that
     * can be assigned to the action.
     * Those are the volunteers assigned to the parent unit,
     * whose status is either available or active.
     *
     * @param $actionId
     * @return mixed
     */
    private function getAvailableVolunteers($actionId) {
        $unit = Unit::whereHas('allActions', function ($query) use ($actionId) {
            $query->where('id', $actionId);
        })->with(['volunteers' => function ($query) {
            $query->active();
        }, 'volunteers' => function ($query) {
            $query->available();
        }])->first();

        return $unit;
    }
}
