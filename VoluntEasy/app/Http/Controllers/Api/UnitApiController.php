<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Unit;
use App\Models\Volunteer;
class UnitApiController extends Controller {

    private \App\Services\UnitService $unitService;
    private \App\Services\VolunteerService $volunteerService;

    public function __construct(\App\Services\UnitService $unitService, \App\Services\VolunteerService $volunteerService) {
        $this->unitService = $unitService;
        $this->volunteerService = $volunteerService;
    }

    public function all() {
        $units = Unit::orderBy('description', 'asc')->with('parent')->get();

        $data = $this->unitService->prepareForDataTable($units);

        return ["data" => $data];
    }

    public function volunteers($id) {
        $volunteers = Volunteer::with(['units' => function ($query) use ($id) {
            $query->where('unit_id', $id);
        }])->get();

        $data = [];
        foreach ($volunteers as $volunteer) {
            if (sizeof($volunteer->units) > 0) {
                $volunteer = $this->volunteerService->setStatusToUnits($volunteer);
                array_push($data, $volunteer);
            }
        }

        return ["data" => $data];
    }

    public function actions($id) {
        $actions = Action::where('unit_id', $id)->orderBy('start_date', 'desc')->get();

        $data = $actions;
        return ["data" => $data];
    }

}
