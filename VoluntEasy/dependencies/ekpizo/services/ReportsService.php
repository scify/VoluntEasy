<?php namespace Dependencies\ekpizo\services;

use App\Models\Action;
use App\Models\VolunteerUnitStatus;
use Interfaces\ReportsServiceAbstract;

class ReportsService extends ReportsServiceAbstract {

    function volunteerHoursByAction() {

        $dbactions = Action::with('volunteers.subtaskShifts')->get();

        $actions = [];

        foreach ($dbactions as $a => $action) {
            $volunteers = [];
            $totalHours = 0;

            foreach ($action->volunteers as $v => $volunteer) {
                $totalVolunteerHours = 0;
                foreach ($volunteer->subtaskShifts as $shift) {
                    $to_time = strtotime($shift->to_hour);
                    $from_time = strtotime($shift->from_hour);
                    $workHours = (($to_time - $from_time) / 60) / 60;
                    $totalVolunteerHours += $workHours;
                    $totalHours += $workHours;
                }

                array_push($volunteers, [
                    'id' => $volunteer->id,
                    'name' => $volunteer->name . ' ' . $volunteer->last_name,
                    'hours' => $totalVolunteerHours,
                ]);
            }
            array_push($actions, [
                'id' => $action->id,
                'description' => $action->description,
                'volunteers' => $volunteers,
                'totalHours' => $totalHours
            ]);
        }

        return $actions;

    }

    /**
     * Get the active and available volunteer
     * per unit by year and month
     */
    public function activeAndAvailableVolunteersByUnit() {
        $volunteerUnitStatuses = VolunteerUnitStatus::with('volunteer', 'unit', 'status')->withTrashed()->get();
        $units = [];
        $unitNames = [];

        foreach ($volunteerUnitStatuses as $vus) {
            $foundUnit = false;

            foreach ($units as $i => $unit) {

                if ( $unit['unit'] == $vus->unit->description) {
                    $foundUnit = true;
                    $status = $vus->status->description;
                    if ($status == 'Active')
                        $units[$i]['activeVolunteers'] = $units[$i]['activeVolunteers'] + 1;
                    if ($status == 'Available')
                        $units[$i]['availableVolunteers'] = $units[$i]['availableVolunteers'] + 1;

                }
            }

            if (!$foundUnit) {
                array_push($units, [
                    'unit' => $vus->unit->description,
                    'activeVolunteers' => 1,
                    'availableVolunteers' => 1,
                ]);
                array_push($unitNames, $vus->unit->description);
            }
        }

        return [
            'units' => $units,
            'unitNames' => $unitNames
        ];
    }

}
