<?php namespace Dependencies\municipality\services;


use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;
use Interfaces\ReportsInterface;

class ReportsService implements ReportsInterface {

    public function getViewPath(){
        return 'municipality.resources.views.reports.all';
    }


    public function volunteersByMonth() {

        $this->volunteerStatuses = VolunteerStatus::all()->lists('description', 'id');

        //this should be dynamic
        $currentYear = date('Y');

        $pending = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $available = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $active = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $new = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $pendingVolunteers = Volunteer::pending()->with('unitsStatus')->get();

        foreach ($pendingVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Pending')
                        $pending[$month - 1]++;
                }
            }
        }


        $availableVolunteers = Volunteer::available()->with('unitsStatus')->get();

        foreach ($availableVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Available')
                        $available[$month - 1]++;
                }
            }
        }

        $activeVolunteers = Volunteer::active()->with('unitsStatus')->get();

        foreach ($activeVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Active')
                        $active[$month - 1]++;
                }
            }
        }

        $allVolunteers = Volunteer::all();

        foreach ($allVolunteers as $volunteer) {
            $month = intval(date("m", strtotime($unit->created_at)));
            $new[$month - 1]++;
        }

        return [
            'active' => $active,
            'available' => $available,
            'pending' => $pending,
            'new' => $new,
        ];
    }

    function volunteersByAgeGroup() {
        // TODO: Implement volunteersByAgeGroup() method.
    }

    function volunteersBySex() {
        // TODO: Implement volunteersBySex() method.
    }

    function volunteersByCity() {
        // TODO: Implement volunteersByCity() method.
    }

    function volunteersByEducationLeve() {
        // TODO: Implement volunteersByEducationLeve() method.
    }

    function volunteersByEducationLevel() {
        // TODO: Implement volunteersByEducationLevel() method.
    }

    function volunteerHoursByAction() {
        // TODO: Implement volunteerHoursByAction() method.
    }
}
