<?php namespace App\Http\Controllers;


use App\Models\Volunteer;

class ReportsController extends Controller{

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
        $withoutActions = Volunteer::whereDoesntHave('actionHistory')->available2()->get();

        //get the volunteers that are available to the unit
        //and also get the last time they participated in an action
        $idles = Volunteer::has('actionHistoryNewest')->with('actionHistoryNewest')->available2()->get()->toArray();


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
}
