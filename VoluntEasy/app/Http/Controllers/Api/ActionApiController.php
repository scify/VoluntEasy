<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Services\Facades\ActionService;

class ActionApiController extends Controller{

    public function all(){
        $actions = Action::with('unit', 'volunteers')->orderBy('description', 'ASC')->get();

        $data = ActionService::prepareForDataTable($actions);

        return [ "data" => $data ];
    }

    public function volunteers($id){
        $volunteers = Volunteer::with(['actions' => function ($query) use ($id) {
            $query->where('action_id', $id);
        }])->get();

        $data = [];
        foreach($volunteers as $volunteer){
            if(sizeof($volunteer->actions)>0) {
                array_push($data, $volunteer);
            }
        }

        return [ "data" => $data ];
    }

}
