<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;

class VolunteerApiController extends Controller{

    public function all(){
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'ASC')->get();
        //$volunteers->setPath(\URL::to('/') . '/volunteers');

        $data = [];
        //get the status of each unit to display to the list
        foreach($volunteers as $volunteer){
            $volunteer = VolunteerService::setStatusToUnits($volunteer);
            array_push($data, $volunteer);
        }

        return ["data" => $data];
    }
}
