<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Volunteer;
use App\Services\Facades\ActionService;
use App\Services\Facades\VolunteerService;

class ActionApiController extends Controller {

    public function all() {
        $actions = Action::with('unit', 'volunteers')->orderBy('description', 'ASC')->get();

        $data = ActionService::prepareForDataTable($actions);

        return ["data" => $data];
    }

    public function volunteers($id) {
        $unitId = Action::findOrFail($id)->unit_id;

        $volunteers = Volunteer::whereHas('actions', function ($q) use ($id) {
            $q->where('action_id', $id);
        })->with(['units' => function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        }])->get();

        $data = [];
        foreach ($volunteers as $volunteer) {
            if (sizeof($volunteer->units) > 0) {
                $volunteer = VolunteerService::setStatusToUnits($volunteer);
                array_push($data, $volunteer);
            }
        }

        return ["data" => $data];
    }

    /**
     * Return the actions in a way that the calendar plugin
     * can display them.
     *
     * @return array
     */
    public function calendar() {

        $calendar = [];

        $actions = Action::all();

        foreach($actions as $action){
            $tmp = ([
                'title' => $action->description,
                'start' => \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->start_date))->format('Y-m-d'),
                'end' => \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d'),
                'description' => $action->comments
            ]);

            array_push($calendar, $tmp);
        }

        return $calendar;

    }

}
