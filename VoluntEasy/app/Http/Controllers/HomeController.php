<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Volunteer;
use App\Services\Facades\UserService;

class HomeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function mainIndex() {
        $available = Volunteer::available()->count();
        $active = Volunteer::active()->count();
        $new = Volunteer::unassigned()->count();
        $pending = Volunteer::pending()->count();
        $blacklisted = Volunteer::blacklisted()->count();
        $actions = Action::active()->count();

        $isAdmin = UserService::isAdmin();

        $birthday = $this->birthdayToday();

        return view('main.dashboard.dashboard', compact('available', 'active', 'new', 'pending', 'blacklisted', 'actions', 'isAdmin', 'birthday'));
    }


    /**
     *
     * Get th3e volunteers that have birthday today
     * @return mixed
     */
    private function birthdayToday() {
        $birthday = [];

        $day = date('d');
        $month = date('m');

        $volunteers = Volunteer::all();

        foreach ($volunteers as $volunteer) {
            $dob = explode("/", $volunteer->birth_date);

            if ($dob[0] == $day && $dob[1] == $month) {
                $birth_date = \Carbon::createFromFormat('d/m/Y', $volunteer->birth_date);
                $volunteer->age = \Carbon::createFromDate($birth_date->year, $birth_date->month, $birth_date->day)->age;
                array_push($birthday, $volunteer);
            }
        }

        return $birthday;
    }

}
