<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\ChecklistItem;

class ChecklistController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Store a resource
     */
    public function store() {

        $checklist = new ChecklistItem([
            'comments' => \Request::get('comments'),
            'subtask_id' => \Request::get('subtask_id'),
            'created_by' => \Auth::user()->id,
            'updated_by' => \Auth::user()->id
        ]);

        $checklist->save();

        return;
    }

    /**
     * Update a resource
     */
    public function update() {

        $checklist = ChecklistItem::find(\Request::get('id'));


        if (\Request::get('isComplete') == 'true')
            $isComplete = 1;
        else
            $isComplete = 0;

        $checklist->isComplete = $isComplete;
        $checklist->update();

        return $checklist;
    }

    /**
     * Delete an item
     */
    public function delete() {
        $checklist = ChecklistItem::find(\Request::get('id'));
        $checklist->delete();
        return;
    }

}
