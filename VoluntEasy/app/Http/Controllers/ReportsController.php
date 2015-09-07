<?php namespace App\Http\Controllers;


use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;

class ReportsController extends Controller {

    private $volunteerStatuses;

    public function __construct() {
        $this->middleware('auth');
    }


    public function index() {


        return view('main.reports.all');
    }

    /**
     * Get the volunteers that have not participated in an action
     * for a long time.
     *
     * @return mixed
     */
    public function idleVolunteers() {

        //get the volunteers that are available to a unit, but
        //have not participated in any action
        $withoutActions = Volunteer::whereDoesntHave('actionHistory')->available()->get();

        //get the volunteers that are available to the unit
        //and also get the last time they participated in an action
        $idles = Volunteer::has('actionHistoryNewest')->with('actionHistoryNewest')->available()->get()->toArray();


        //sort the array by idlest
        usort($idles, function ($a, $b) {
            return $a['action_history_newest']['created'] > $b['action_history_newest']['created'] ? 1 : -1;
        });


        return [
            'withoutActions' => $withoutActions,
            'idles' => $idles
        ];

        return $idles;
        return $withoutActions;
    }


    /**
     * Get the volunteer status by month
     *
     * @return mixed
     */


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


    /*
    public function volunteersByMonth() {

        $this->volunteerStatuses = VolunteerStatus::all()->lists('description', 'id');

        //this should be dynamic
        $currentYear = date('Y');


        $pendingVolunteers = Volunteer::pending()->with('unitsStatus')->get();

        for ($i = 1; $i < 13; $i++) {
            $monthlyReport = new MonthlyReport($i);
            $this->pending[$i] = $monthlyReport;
        }

        foreach ($pendingVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Pending')
                        $this->pending[$month]->volunteers++;
                }
            }
        }


        $availableVolunteers = Volunteer::available()->with('unitsStatus')->get();

        for ($i = 1; $i < 13; $i++) {
            $monthlyReport = new MonthlyReport($i);
            $this->available[$i] = $monthlyReport;
        }

        foreach ($availableVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Pending')
                        $this->available[$month]->volunteers++;
                }
            }
        }

        $activeVolunteers = Volunteer::active()->with('unitsStatus')->get();

        for ($i = 1; $i < 13; $i++) {
            $monthlyReport = new MonthlyReport($i);
            $this->active[$i] = $monthlyReport;
        }

        foreach ($activeVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Pending')
                        $this->active[$month]->volunteers++;
                }
            }
        }

        return [
            'active' => $this->active,
            'available' => $this->available,
            'pending' => $this->pending,
        ];
    }
*/

}
