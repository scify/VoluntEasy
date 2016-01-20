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
    public function edit($actionId) {

        return view('main.tasks.edit', compact('actionId'));
    }


    /**
     * Update a resource
     */
    public function update(TaskRequest $request) {

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

}
