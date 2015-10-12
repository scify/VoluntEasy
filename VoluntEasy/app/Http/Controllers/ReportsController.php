<?php namespace App\Http\Controllers;


use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;

class ReportsController extends Controller {

    private $reportsService;
    private $volunteerStatuses;

    public function __construct() {
        $this->middleware('auth');
        $this->reportsService =  \App::make('Interfaces\ReportsInterface');
    }


    public function index() {

        return view($this->reportsService->getViewPath());
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

       return $this->reportsService->volunteersByMonth();
    }

    /**
     * Get the volunteer status by sex
     *
     * @return mixed
     */
    public function volunteersBySex() {

        return $this->reportsService->volunteersBySex();
    }

    /**
     * Get the volunteer status by city
     *
     * @return mixed
     */
    public function volunteersByCity() {

        return $this->reportsService->volunteersByCity();
    }

    /**
     * Get the volunteer status by age group
     *
     * @return mixed
     */
    public function volunteersByAgeGroup() {

        return $this->reportsService->volunteersByAgeGroup();
    }

    /**
     * Get the volunteer status by education level
     *
     * @return mixed
     */
    public function volunteersByEducationLevel() {

        return $this->reportsService->volunteersByEducationLevel();
    }
}
