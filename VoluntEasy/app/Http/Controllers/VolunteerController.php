<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;
use App\Http\Requests\VolunteerFormRequest as VolunteerFormRequest;
use Illuminate\Support\Facades\Redirect;
use DB;
use Validator;

class VolunteerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        $vol = Volunteer::all();

        $vol->load('availabilityFrequencies', 'availabilityTimes', 'driverLicenceType', 'identificationType', 'maritalStatus', 'interests');

        $vol->load('languages.level', 'languages.language');

        $vol->load('actions.steps.status');

        return $vol;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('main.volunteers.list');
    }

    /**
     * Display new volunteer form
     *
     * @return \Illuminate\View\View
     */
    public function newVolunteer()
    {
        return view('main.volunteers.new');
    }


    /**
     * Display volunteer statistics
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        return view('main.volunteers.statistics');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public
    function create()
    {
	    $identityTypes = DB::table('identification_types')->lists('description', 'id');
	    $driverLicenses = DB::table('driver_license_types')->lists('description', 'id');
	    $maritalTypes = DB::table('marital_statuses')->lists('description', 'id');
	    $languages = DB::table('languages')->lists('description', 'id');
	    $lang_levels = DB::table('language_levels')->lists('description', 'id');
	    $work_statuses = DB::table('work_statuses')->lists('description', 'id');
	    $availability_freqs = DB::table('availability_freqs')->lists('description', 'id');
	    $availability_times = DB::table('availability_time')->lists('description', 'id');
	    $genders = DB::table('genders')->lists('description', 'id');
	    $comm_method = DB::table('comm_method')->lists('description', 'id');
	    $ed_level = DB::table('education_levels')->lists('description', 'id');
	    return view('main.volunteers.new')->with('id_type', $identityTypes)->with('driver_license_type', $driverLicenses)->with('marital_status', $maritalTypes)->with('languages', $languages)->with('lang_levels', $lang_levels)->with('work_statuses', $work_statuses)->with('availability_freqs', $availability_freqs)->with('availability_times', $availability_times)->with('genders', $genders)->with('comm_method', $comm_method)->with('ed_level', $ed_level);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public
    function store(VolunteerFormRequest $request)
    {
	    dd($request);
	    $data = new Volunteer(array(
			'name' => \Input::get('name'),
			'last_name' => \Input::get('last_name'),
			'fathers_name' => \Input::get('fathers_name'),
			'birth_date' => \Input::get('birth_date'),
			'identification_type_id' => \Input::get('identification_type_id'),
			'identification_num' => \Input::get('identification_num'),
			'gender_id' => \Input::get('gender_id'),
			'marital_status_id' => \Input::get('marital_status_id'),
			'children' => \Input::get('children'),
			'address' => \Input::get('address'),
			'post_box' => \Input::get('post_box'),
			'city' => \Input::get('city'),
			'country' => \Input::get('country'),
			'live_in_curr_country' => \Input::get('live_in_curr_country'),
			'home_tel' => \Input::get('home_tel'),
			'work_tel' => \Input::get('work_tel'),
			'cell_tel' => \Input::get('cell_tel'),
			'fax' => \Input::get('fax'),
			'email' => \Input::get('email'),
			'comm_method_id' => \Input::get('comm_method'),
			'education_level_id' => \Input::get('education_level_id'),
			'education_level_id' => \Input::get('education_level_id'),
			'specialty' => \Input::get('specialty'),
			'department' => \Input::get('department'),
			'driver_license_type_id' => \Input::get('driver_license_type_id'),
			'computerUse' => \Input::get('computerUse'),
			'additional_skills' => \Input::get('additional_skills'),
			// TODO: languages.
			'extra_lang' => \Input::get('extra_lang'),
			'work_status_id' => \Input::get('work_status_id'),
			'work_description' => \Input::get('work_description'),
			'participation_reason' => \Input::get('participation_reason'),
			'participation_actions' => \Input::get('participation_actions'),
			'participation_previous' => \Input::get('participation_previous'),
			'availability_freqs_id' => \Input::get('availability_freqs_id'),
		));

	    // $data->save();
	    return 'Thanks for registering a volunteer...';
	    // dd($request->all());
            /*
	     * $this->validate($request, [
		 *     'name' => 'required',
		 *     'last_name' => 'required',
		 *     'fathers_name' => 'required',
		 *     'birth_date' => 'required',
		 *     'gender_id' => 'required',
		 *     'email' => 'required|email|unique',
		 *     'education_level_id' => 'required',
		 *     'woth_status_id' => 'required',
		 *     'participation_reason' => 'required',
	     * ]);
             */

	    // Volunteer::create($request->all());

	    return Redirect::to('volunteers/listview');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        //
    }

    public function getNew(){
        return VolunteerService::getNew();
    }

}
