<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Descriptions\StepStatus;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;

class VolunteerApiController extends Controller {

    public function all() {
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'ASC')->get();
        //$volunteers->setPath(\URL::to('/') . '/volunteers');

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
            $volunteers = Volunteer::unassigned();
        else if ($status == 'active')
            $volunteers = Volunteer::active();
        else if ($status == 'available')
            $volunteers = Volunteer::available();
        else if ($status == 'pending') {
            $pending = Volunteer::pending();

            foreach ($pending as $volunteer) {
                $id = $volunteer->id;
                $pendingStatus = StepStatus::incomplete();

                $volunteer = Volunteer::with(['units.steps' => function ($query) use ($id, $pendingStatus) {
                    $query->whereHas('statuses', function ($query) use ($id, $pendingStatus) {
                        $query->where('volunteer_id', $id)->where('step_status_id', $pendingStatus);
                    });
                }])->where('id', $id)->first();

                array_push($volunteers, $volunteer);
            }
        }
        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = VolunteerService::prepareForDataTable($volunteers);

        return ["data" => $data];
    }


}
