<?php namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Action;
use App\Models\ActionTasks\Task;

class TaskController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show create form
     */
    public function create($actionId) {

        return view('main.tasks.create', compact('actionId'));

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
            'isComplete' => $isComplete
        ]);

        $task->save();

        return \Redirect::route('action/one', ['id' => $request['actionId']]);
    }

    /**
     * Show edit form
     */
    public function edit($taskId) {

        $task = Task::findOrFail($taskId);

        return view('main.tasks.edit', compact('task'));
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
    public function destroy($id){

        $task = Task::with('volunteers')->findOrFail($id);

        if(sizeof($task->volunteers)>0){
            \Session::flash('flash_message', 'Το task περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            \Session::flash('flash_type', 'alert-danger');
            return;
        }

        \Session::flash('flash_message', 'Η δράση διαγράφηκε.');
        \Session::flash('flash_type', 'alert-success');

        $task->delete();

        return;
    }

}
