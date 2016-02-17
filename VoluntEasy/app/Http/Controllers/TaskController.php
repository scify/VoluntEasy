<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
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
    public function show($id) {
        $task = Task::findOrFail($id);

        return $task;
    }

    /**
     * Store a new resource
     */
    public function store() {

        if(!\Request::has('status_id'))
            $status_id = Status::todo();
        else
            $status_id = \Request::get('status_id');

        if(\Request::has('task-due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('task-due_date'));
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

        return $task;
    }


    /**
     * Update a resource
     */
    public function update() {

        $task = Task::findOrFail(\Request::get('taskId'));

        if(!\Request::has('status_id'))
            $status_id = Status::todo();
        else
            $status_id = \Request::get('status_id');

        if(\Request::has('due_date'))
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


        return \Redirect::route('action/one', ['id' => \Request::get('actionId')]);
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



}
