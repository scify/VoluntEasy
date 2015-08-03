<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Services\Facades\UnitService;
use App\Services\Facades\VolunteerService;

class UnitApiController extends Controller{

    public function all(){
        $units = Unit::orderBy('description', 'ASC')->with('parent')->get();

        $data = UnitService::prepareForDataTable($units);

        return [ "data" => $data ];
    }

    public function volunteers($id){
        $volunteers = Volunteer::with(['units' => function ($query) use ($id) {
            $query->where('unit_id', $id);
        }])->get();

        $data = [];
        foreach($volunteers as $volunteer){
            if(sizeof($volunteer->units)>0) {
                $volunteer = VolunteerService::setStatusToUnits($volunteer);
                array_push($data, $volunteer);
            }
        }

        return [ "data" => $data ];
    }

    public function actions($id){
        $actions = Action::where('unit_id', $id)->get();

        $data = $actions;
        return [ "data" => $data ];
    }

}
