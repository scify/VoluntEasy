<?php namespace Dependencies\municipality\services;

use App\Models\Action;
use App\Models\Descriptions\Interest;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;
use Interfaces\ReportsServiceAbstract;

class ReportsService extends ReportsServiceAbstract {

    public function getViewPath() {
        return 'municipality.resources.views.reports.all';
    }

    function volunteersByInterest() {

        $interests = Interest::all();

        foreach ($interests as $interest) {

            $id = $interest->id;
            $volunteers = Volunteer::whereHas('interests', function ($query) use ($id) {
                $query->where('interest_id', $id);
            })->count();

            $interest->count = $volunteers;
        }

        return $interests;
    }

    function volunteersByAction() {

        $actions = Action::all();

        foreach ($actions as $action) {

            $id = $action->id;

            $volunteers = Volunteer::whereHas('actionHistory', function ($query) use ($id) {
                $query->where('action_id', $id);
            })->count();

            $now = date('Y-m-d');
            $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d');
            $action->expired = false;
            if ($endDate < $now)
                $action->expired = true;

            $action->volunteer_count = $volunteers;
        }

        return ['data' => $actions];
    }

    /**
     * Get the active and available volunteer
     * per unit by year and month
     */
    public function activeAndAvailableVolunteersByUnit() {
        $volunteerUnitStatuses = VolunteerUnitStatus::with('volunteer', 'unit', 'status')->get();
        $units = [];

        foreach ($volunteerUnitStatuses as $vus) {
            $foundUnit = false;
            foreach ($units as $unit) {
                if ($unit['unit'] == $vus->unit->description) {
                    $foundUnit = true;
                    if ($vus->status->description == 'Active')
                        $units['activeVolunteers'] = $units['activeVolunteers']++;
                    else
                        $units['availableVolunteers'] = $units['availableVolunteers']++;
                }
            }
            if (!$foundUnit) {
                $units['unit'] = $vus->unit->description;
                $units['activeVolunteers'] = 0;
                $units['availableVolunteers'] = 0;
            }
        }

        return $units;
    }
}
