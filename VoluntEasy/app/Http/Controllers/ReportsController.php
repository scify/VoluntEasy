<?php namespace App\Http\Controllers;


use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;

class ReportsController extends Controller{

    private $volunteerStatuses;



    public function __construct() {
        $this->middleware('auth');
    }


    public function index(){




        return view('main.reports.all');
    }

    /**
     * Get the volunteers that have not participated in an action
     * for a long time.
     *
     * @return mixed
     */
    public function idleVolunteers(){

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
    public function volunteersByMonth(){

        $volunteerStatuses = VolunteerStatus::all()->lists('description', 'id');


        return $volunteerStatuses;

        $august = Volunteer::where(\DB::raw('MONTH(created_at)'), '=', 1 )
            ->where(\DB::raw('YEAR(created_at)'), '=', date('Y') )
            ->with('units')->get();

        foreach($august as $volunteer){
            $volunteer = VolunteerService::setStatusToUnits($volunteer);
        }



        $september = Volunteer::where(\DB::raw('MONTH(created_at)'), '=', 1 )
            ->where(\DB::raw('YEAR(created_at)'), '=', date('Y') )
            ->with('units')->get();

        foreach($september as $volunteer){
            $volunteer = VolunteerService::setStatusToUnits($volunteer);
        }










        $pending = VolunteerStatus::pending();
        $available = VolunteerStatus::available();
        $active = VolunteerStatus::active();
        //new???


        return $volunteers;
    }







    private function setStatusToUnits($volunteer) {

        foreach ($volunteer->units as $unit) {

            $statusId = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                ->where('unit_id', $unit->id)->first()->volunteer_status_id;

            $unit->status = $this->volunteerStatuses[statusId];
        }

        return $volunteer;
    }







}
