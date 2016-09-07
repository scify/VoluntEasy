<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Descriptions\StepStatus;
use App\Models\Volunteer;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;

class VolunteerApiController extends Controller {


    public function __construct() {
    }

    public function all() {
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'ASC')->get();

        /*
                //get the total rating for each attribute
                foreach ($volunteers as $volunteer) {
                    if ($volunteer->ratings != null) {
                        $volunteer->rating_attr1 = $volunteer->ratings->rating_attr1 / $volunteer->ratings->rating_attr1_count;
                        $volunteer->rating_attr2 = $volunteer->ratings->rating_attr2 / $volunteer->ratings->rating_attr2_count;
                        $volunteer->rating_attr3 = $volunteer->ratings->rating_attr3 / $volunteer->ratings->rating_attr3_count;
                    } else {
                        $volunteer->rating_attr1 = 0;
                        $volunteer->rating_attr2 = 0;
                        $volunteer->rating_attr3 = 0;
                    }
                }
        */
        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = VolunteerService::prepareForDataTable($volunteers);

        return ["data" => $data];
    }

    /**
     * Get volunteer by status
     *
     * @param $status
     * @return array
     */
    public function status($status) {
        $volunteers = [];

        if ($status == 'new')
            $volunteers = Volunteer::unassigned()->get();
        else if ($status == 'active')
            $volunteers = Volunteer::active()->get();
        else if ($status == 'available')
            $volunteers = Volunteer::available()->get();
        else if ($status == 'pending') {
            $pending = Volunteer::pending()->get();

            foreach ($pending as $volunteer) {
                $id = $volunteer->id;
                $pendingStatus = StepStatus::incomplete();
                $permittedUnits = UserService::userUnits();

                $volunteer = Volunteer::with(['units' => function ($q) use ($id, $pendingStatus, $permittedUnits) {
                    $q->whereIn('unit_id', $permittedUnits)->with(['steps' => function ($query) use ($id, $pendingStatus) {
                        $query->whereHas('statuses', function ($query) use ($id, $pendingStatus) {
                            $query->where('volunteer_id', $id)->where('step_status_id', $pendingStatus);
                        });
                    }]);
                }])->where('id', $id)->first();

                if (sizeof($volunteer->units) > 0 && VolunteerService::isPermitted($id))
                    array_push($volunteers, $volunteer);
            }
        }
        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = VolunteerService::prepareForDataTable($volunteers);

        return ["data" => $data];
    }

    public function show($id) {
        $volunteer = VolunteerService::fullProfile($id);
        $volunteer = VolunteerService::setStatusToUnits($volunteer);

        //get the count of pending and available units, used in the front end
        $pending = 0;
        $available = 0;
        foreach ($volunteer->units as $unit) {
            if ($unit->status == 'Pending')
                $pending++;
            else if ($unit->status == 'Available' || $unit->status == 'Active')
                $available++;
        }

        //check if the volunteer is permitted to be edited by the
        //currently logged in user
        $permittedVolunteers = UserService::permittedVolunteersIds();
        if (in_array($volunteer->id, $permittedVolunteers))
            $volunteer->permitted = true;
        else
            $volunteer->permitted = false;

        return $volunteer;
    }

    /**
     * Method is used to communicate between various sites and the platform.
     * We save the volunteer data sent from external sites to the platform.
     *
     * @return mixed
     */
    public function apiStore() {
        dd(\Request::all());

        $volunteerService = \App::make('Interfaces\VolunteerInterface');

//        return $volunteerService->apiStore();

        $saved = $volunteerService->store();

        dd($saved['messages']);

        if ($saved['failed']) {
            return redirect()->back()->withErrors($saved['messages'])->withInput();
        } else {
            return redirect()->back();
        }
    }


}
