<?php namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\CTA\PublicAction;
use App\Models\CTA\PublicActionSubTask;

class CTAController extends Controller {


    public function __construct() {
        $this->middleware('auth', ['except' => ['cta']]);
    }


    public function cta() {

        $action = Action::find(1);

        return view('main.cta.cta', compact('action'));
    }

    public function participate($id) {

        $publicAction = PublicAction::where('public_url', $id)->first();

        if ($publicAction != null && $publicAction->isActive) {
            $publicAction = $publicAction;
            $action = $publicAction->load('action.tasks.subtasks.workDates.volunteers')->action;
            return view('main.cta.participate', compact('action', 'publicAction'));
        } else {
            return view('main.cta.participate');
        }
    }

    public function store() {

        $publicAction = new PublicAction([
            'description' => \Request::get('public_description'),
            'address' => \Request::get('public_address'),
            'map_url' => \Request::get('public_map_url'),
            'executive_name' => \Request::get('public_exec_name'),
            'executive_email' => \Request::get('public_exec_email'),
            'executive_phone' => \Request::get('public_exec_phone'),
            'public_url' => \Request::get('actionId') . '-' . \Request::get('actionName'),
            'isActive' => true,
            'action_id' => \Request::get('actionId')
        ]);

        $publicAction->save();

        $this->savePublicSubtasks($publicAction);

        return $publicAction;

    }

    public function update() {
        $publicAction = PublicAction::find(\Request::get('publicActionId'));

        $publicAction->update([
            'description' => \Request::get('public_description'),
            'address' => \Request::get('public_address'),
            'map_url' => \Request::get('public_map_url'),
            'executive_name' => \Request::get('public_exec_name'),
            'executive_email' => \Request::get('public_exec_email'),
            'executive_phone' => \Request::get('public_exec_phone'),
            'public_url' => \Request::get('actionId') . '-' . \Request::get('actionName'),
            'isActive' => true,
            'action_id' => \Request::get('actionId')
        ]);

       return  $this->savePublicSubtasks($publicAction);

        return $publicAction;

    }

    /**
     * Save the subtasks that will be displayed on the public page
     */
    private function savePublicSubtasks($publicAction) {
        //save subtasks

        $publicSubtasksIds = [];
        foreach (\Request::get('subtasks')['id'] as $i => $id) {

            $publicSubtask = new PublicActionSubTask([
                'public_actions_id' => $publicAction->id,
                'subtask_id' => $id,
                'description' => \Request::get('subtasks')['comments'][$i],
            ]);
            $publicSubtask->save();
            array_push($publicSubtasksIds, $id);
        }

        return PublicActionSubTask::where('public_actions_id', $publicAction->id)->whereNotIn('id', $publicSubtasksIds)->get()->toArray();

        return;
    }
}
