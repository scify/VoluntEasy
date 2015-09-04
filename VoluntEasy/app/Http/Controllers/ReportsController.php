<?php namespace App\Http\Controllers;


use App\Models\Descriptions\VolunteerStatus;
use App\Models\DTO\MonthlyReport;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;

class ReportsController extends Controller {

    private $volunteerStatuses;
    private $available = [];
    private $pending = [];
    private $active = [];


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


        //this shoukld be dynamic
        $currentYear = date('Y');

        /*
                $august = Volunteer::where(\DB::raw('MONTH(created_at)'), '=', 8)
                    ->where(\DB::raw('YEAR(created_at)'), '=', $currentYear)
                    ->with('units')->get();

                foreach ($august as $volunteer) {
                    $volunteer = $this->setStatusToUnits($volunteer, 8);
                }

        */


        $pendingVolunteers = Volunteer::pending()->with('unitsStatus')->get();

        // return $pendingVolunteers;


        for ($i = 1; $i < 13; $i++) {

            $monthlyReport = new MonthlyReport(['month' => $i]);

          //  return ($monthlyReport);

            array_push($this->pending, $monthlyReport);
        }

        var_dump($this->pending);

        return ($this->pending);

        foreach ($pendingVolunteers as $volunteer) {

            foreach ($volunteer->units as $unit) {


                $month = date("m", strtotime($unit->created_at));
                return $month;
            }
        }


        $septemberReport = new MonthlyReport(9);

        $september = Volunteer::where(\DB::raw('MONTH(created_at)'), '=', 9)
            ->where(\DB::raw('YEAR(created_at)'), '=', $currentYear)
            ->with('units')->get();

        foreach ($september as $volunteer) {
            $volunteer = $this->setStatusToUnits($volunteer, 9);
        }

        $septemberReport->setVolunteers($september);

        $pending = VolunteerStatus::pending();
        $available = VolunteerStatus::available();
        $active = VolunteerStatus::active();
        //new???
        return 'aa';

        return [
            'active' => $this->active,
            'available' => $this->available,
            'pending' => $this->pending,
        ];
    }


    private function setStatusToUnits($volunteer, $month) {

        foreach ($volunteer->units as $unit) {

            $statusId = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                ->where('unit_id', $unit->id)->first()->volunteer_status_id;

            $unit->status = $this->volunteerStatuses[$statusId];

            if ($this->volunteerStatuses[$statusId] == 'Available') {
                array_push($this->available[$month], $volunteer);
            } else if ($this->volunteerStatuses[$statusId] == 'Pending') {

                // $this->pending[$month]->volunteers = $volunteer;


                array_push($this->pending[$month]->volunteers, $volunteer);


                dd($this->pending);

            }
        }
        return $volunteer;
    }


}
