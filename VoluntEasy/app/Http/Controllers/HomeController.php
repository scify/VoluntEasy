<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Services\Facades\VolunteerService;

class HomeController extends Controller
{

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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function mainIndex()
    {
        $volunteers = VolunteerService::getNew()->count();
        $actions = Action::all()->count();

        return view('main.dashboard', compact('volunteers', 'actions'));
    }

}
