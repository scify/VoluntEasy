<?php namespace Dependencies\ekpizo\services;


use App\Models\Descriptions\Gender;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;
use Interfaces\ReportsInterface;

class ReportsService implements ReportsInterface {


    public function getViewPath() {
        return 'ekpizo.resources.views.reports.all';
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

        $manId = Gender::where('description', 'Άνδρας')->first()->id;
        $womanId = Gender::where('description', 'Γυναίκα')->first()->id;

        $men = Volunteer::where('gender_id', $manId)->count();
        $women = Volunteer::where('gender_id', $womanId)->count();

        return [
            'men' => $men,
            'women' => $women
        ];
    }

    function volunteersByCity() {
        $volunteers = Volunteer::get(['city']);

        $byCity = [];

        foreach ($volunteers as $volunteer) {
            if (array_key_exists($volunteer->city, $byCity))
                $byCity[$volunteer->city] = $byCity[$volunteer->city] + 1;
            else
                $byCity[$volunteer->city] = 1;
        }

        $volunteers = [];
        foreach ($byCity as $key => $bc) {
            array_push($volunteers, [
                'city' => $key,
                'count' => $bc
            ]);

        }

        return $volunteers;
    }

    function volunteersByEducationLevel() {
        // TODO: Implement volunteersByEducationLeve() method.
    }
}
