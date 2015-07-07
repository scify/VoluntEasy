<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\VolunteerRequest;
use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Volunteer;
use App\Models\VolunteerLanguage;
use App\Services\Facades\UnitService;
use App\Services\Facades\VolunteerService;
use DB;
use Illuminate\Support\Facades\View;

class VolunteerController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function all() {

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
    public function index() {
        $volunteers = Volunteer::with('units', 'actions')->paginate(5);
        $volunteers->setPath(\URL::to('/').'/users');

        return view('main.volunteers.list', compact('volunteers', 'maritalStatus'));
    }

    /**
     * Display new volunteer form
     *
     * @return \Illuminate\View\View
     */
    public function newVolunteer() {
        return view('main.volunteers.new');
    }


    /**
     * Display volunteer statistics
     *
     * @return \Illuminate\View\View
     */
    public function statistics() {
        return view('main.volunteers.statistics');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $identificationTypes = IdentificationType::all()->lists('description', 'id');
        $driverLicenseTypes = DriverLicenceType::all()->lists('description', 'id');
        $maritalStatuses = MaritalStatus::all()->lists('description', 'id');
        $languages = Language::all()->lists('description', 'id');
        $langLevels = LanguageLevel::all()->lists('description', 'id');
        $workStatuses = WorkStatus::all()->lists('description', 'id');
        $availabilityFreqs = AvailabilityFrequencies::all()->lists('description', 'id');
        $availabilityTimes = AvailabilityTime::all()->lists('description', 'id');
        $genders = Gender::all()->lists('description', 'id');
        $commMethod = CommunicationMethod::all()->lists('description', 'id');
        $edLevel = EducationLevel::all()->lists('description', 'id');

        return view('main.volunteers.new', compact('identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
                    'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'genders', 'commMethod', 'edLevel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VolunteerRequest $request
     * @return Response
     */
    public function store(VolunteerRequest $request) {

        $volunteer = new Volunteer(array(
            'name' => \Input::get('name'),
            'last_name' => \Input::get('last_name'),
            'fathers_name' => \Input::get('fathers_name'),
            'birth_date' => \Input::get('birth_date'),
            'identification_type_id' => intval(\Input::get('identification_type_id')),
            'identification_num' => \Input::get('identification_num'),
            'gender_id' => intval(\Input::get('gender_id')),
            'marital_status_id' => intval(\Input::get('marital_status_id')),
            'children' => intval(\Input::get('children')),
            'address' => \Input::get('address'),
            'post_box' => intval(\Input::get('post_box')),
            'city' => \Input::get('city'),
            'country' => \Input::get('country'),
            'live_in_curr_country' => intval(\Input::get('live_in_curr_country')),
            'home_tel' => \Input::get('home_tel'),
            'work_tel' => \Input::get('work_tel'),
            'cell_tel' => \Input::get('cell_tel'),
            'fax' => \Input::get('fax'),
            'email' => \Input::get('email'),
            'comm_method_id' => intval(\Input::get('comm_method_id')),
            'education_level_id' => intval(\Input::get('education_level_id')),
            'specialty' => \Input::get('specialty'),
            'department' => \Input::get('department'),
            'driver_license_type_id' => intval(\Input::get('driver_license_type_id')),
            'computer_usage' => intval(\Input::get('computer_usage')),
            'additional_skills' => \Input::get('additional_skills'),
            'extra_lang' => \Input::get('extra_lang'),
            'work_status_id' => intval(\Input::get('work_status_id')),
            'work_description' => \Input::get('work_description'),
            'participation_reason' => \Input::get('participation_reason'),
            'participation_actions' => \Input::get('participation_actions'),
            'participation_previous' => \Input::get('participation_previous'),
            'availability_freqs_id' => intval(\Input::get('availability_freqs_id')),
        ));

        // return $volunteer;

        $volunteer->save();

        $unit = UnitService::getRoot();

        $volunteer->units()->save($unit);


        $languages = Language::all();

        //Get all languages, and check if they are selected
        foreach ($languages as $language) {
            if (\Input::has('lang' . $language->id)) {
                $level = LanguageLevel::where('id', \Input::get('lang' . $language->id))->first();

                //create a new VolunteerLanguage that has
                $volLanguage = new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => $language->id,
                    'language_level_id' => \Input::get('lang' . $language->id)
                ]);

                $volunteer->languages()->save($volLanguage);
            }
        }
        return 'Thanks for registering a volunteer... ID: ' . $volunteer->id;
        //  return Redirect::to('volunteers/listview');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    /**
     * Search all volunteers and re-render the partial
     * that contains the table with the volunteer data.
     *
     * @return mixed
     */
    public function search() {
        $volunteers = VolunteerService::search();

        $view = View::make('main.volunteers.list')->with('volunteers', $volunteers);
        return $view->renderSections()['table'];
    }


    public function getNew() {
        return VolunteerService::getNew();
    }

}
