<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Volunteers\VolunteerProfile;
use Interfaces\VolunteerInterface;
use App\Models\Descriptions\StepStatus;
use App\Models\Volunteer;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;

class VolunteerApiController extends Controller {

    public function __construct() {
    }

    public function all() {
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'asc')->get();

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
        $volunteer = app(VolunteerProfile::class)->fullProfile($id);
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

        //chekc if the volunteer is permitted to be edited by the
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
    public function apiStore(VolunteerInterface $volunteerService) {
        return $volunteerService->apiStore();
    }

}
