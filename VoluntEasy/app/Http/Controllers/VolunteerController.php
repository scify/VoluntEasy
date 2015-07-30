<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\VolunteerRequest;
use App\Models\Action;
use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Interests;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Volunteer;
use App\Models\VolunteerAvailabilityTime;
use App\Models\VolunteerLanguage;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use DB;
use Illuminate\Support\Facades\View;

class VolunteerController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'ASC')->get();
        //$volunteers->setPath(\URL::to('/') . '/volunteers');

        //get the status of each unit to display to the list
        foreach($volunteers as $volunteer){
            $volunteer = VolunteerService::setStatusToUnits($volunteer);
        }

        return view('main.volunteers.list', compact('volunteers'));
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
        $interests = Interests::all()->lists('description', 'id');
        $genders = Gender::all()->lists('description', 'id');
        $commMethod = CommunicationMethod::all()->lists('description', 'id');
        $edLevel = EducationLevel::all()->lists('description', 'id');

        return view('main.volunteers.create', compact('identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interests', 'genders', 'commMethod', 'edLevel'));
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
            'comments' => intval(\Input::get('comments')),
        ));

        /* Solve mySql problem regarding date format. Postgres works fine, while mySql stores date
         * as 0000-00-00. Solve using Carbon. */
        $volunteer->birth_date = \Carbon::createFromFormat('d/m/Y', $volunteer->birth_date)->toDateString();

        $volunteer->save();

        $unit = UnitService::getRoot();

        $volunteer->units()->save($unit);

//        // Save availability time from checkbox.
//        $volunteer_availability = [
//            'availability_time_id' => intval(\Input::get('availability_time')),
//        ];
//
//        $volunteer->availabilityTimes()->sync($volunteer_availability);
        $availability_times = AvailabilityTime::all();

        $availability_array = [];
        foreach ($availability_times as $availability_time) {
            if (\Input::has('availability_time' . $availability_time->id)) {
                array_push($availability_array, $availability_time->id);
            }
        }

        $volunteer->availabilityTimes()->sync($availability_array);

        $interests = Interests::all();

        // Get interests selected and pass values to volunteer_interests table.
        $interest_array = [];
        foreach ($interests as $interest) {
            if (\Input::has('interest' . $interest->id)) {
                array_push($interest_array, $interest->id);
            }
        }
        $volunteer->interests()->sync($interest_array);

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

        return \Redirect::route('volunteer/one', ['id' => $volunteer->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $volunteer = VolunteerService::fullProfile($id);
        $timeline = VolunteerService::timeline($id);

        $volunteer = VolunteerService::setStatusToUnits($volunteer);

        //get the count of pending and available units, used in the front end
        $pending = 0;
        $available = 0;
        foreach($volunteer->units as $unit){
            if($unit->status=='Pending')
                $pending++;
            else if ($unit->status=='Available' || $unit->status=='Active')
                $available++;
        }

        $permitted=0;
        if(in_array($volunteer->id, UserService::permittedVolunteersIds()))
            $permitted=1;

       //return $volunteer;

        return view("main.volunteers.show", compact('volunteer', 'pending', 'available', 'permitted', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($volId) {
        $volunteer = Volunteer::with('interests', 'availabilityTimes')->findOrFail($volId);

        $identificationTypes = IdentificationType::all()->lists('description', 'id');
        $driverLicenseTypes = DriverLicenceType::all()->lists('description', 'id');
        $maritalStatuses = MaritalStatus::all()->lists('description', 'id');
        $languages = Language::all()->lists('description', 'id');
        $langLevels = LanguageLevel::all()->lists('description', 'id');
        $workStatuses = WorkStatus::all()->lists('description', 'id');
        $availabilityFreqs = AvailabilityFrequencies::all()->lists('description', 'id');
        $availabilityTimes = AvailabilityTime::all()->lists('description', 'id');
        $interests = Interests::all()->lists('description', 'id');
        $genders = Gender::all()->lists('description', 'id');
        $commMethod = CommunicationMethod::all()->lists('description', 'id');
        $edLevel = EducationLevel::all()->lists('description', 'id');


        return view('main.volunteers.edit', compact('volunteer', 'identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interests', 'genders', 'commMethod', 'edLevel'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(VolunteerRequest $request) {

        $volunteer = Volunteer::findOrFail($request->get('id'));

        // update everything except middle table stuff
        $volunteer->update(
            array(
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
                'comments' => \Input::get('comments'),
            ));

        // update middle table relations
        $availability_times = AvailabilityTime::all();

        $availability_array = [];
        foreach ($availability_times as $availability_time) {
            if (\Input::has('availability_time' . $availability_time->id)) {
                array_push($availability_array, $availability_time->id);
            }
        }

        $volunteer->availabilityTimes()->sync($availability_array);

        $interests = Interests::all();

        // Get interests selected and pass values to volunteer_interests table.
        $interest_array = [];
        foreach ($interests as $interest) {
            if (\Input::has('interest' . $interest->id)) {
                array_push($interest_array, $interest->id);
            }
        }
        $volunteer->interests()->sync($interest_array);

        //Save languages + levels
        $volunteerLanguages = $volunteer->languages()->get();

        foreach ($volunteerLanguages as $language) {
            if (\Input::has('lang' . $language->language_id)) {
                $language->language_level_id = \Input::get('lang' . $language->language_id);
                $language->save();
            }
        }

        $languages = Language::all();
        $languages_array = [];
        //Get all languages, and check if they are selected
        foreach ($languages as $language) {
            $langId = \Input::has('lang' . $language->id);

            if ($langId && !in_array($language->id, $volunteerLanguages->lists('language_id'))) {
                //create a new VolunteerLanguage
                $volLanguage = new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => $language->id,
                    'language_level_id' => \Input::get('lang' . $language->id)
                ]);

                array_push($languages_array, $volLanguage);
            }
        }
        $volunteer->languages()->saveMany($languages_array);

        return \Redirect::route('volunteer/one', ['id' => $volunteer->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->delete();

        return $id;
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


    public function newVolunteers() {
        $volunteers = Volunteer::unassigned();

        return view('main.volunteers.list', compact('volunteers'));
    }

    /**
     * Add a volunteer to the root unit
     * when the user is admin.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addToRootUnit($id) {

        if (VolunteerService::addToRootUnit($id))
            return \Redirect::route('volunteer/one', ['id' => $id]);
        else
            return response()->view('errors.550', [], 550);
    }

    /**
     * Add a volunteer to a unit
     * and also create the steps that are needed (status set to incomplete)
     *
     * @return mixed
     */
    public function addToUnit() {

        $unitId = \Request::get('assign_id');
        $parentUnitId = \Request::get('parent_unit_id');
        $volunteerId = \Request::get('volunteer_id');

        return VolunteerService::addToUnit($unitId, $parentUnitId, $volunteerId);
    }

    /**
     * Add a volunteer to a certain action
     *
     * @return mixed
     */
    public function addToAction() {

        $action = Action::find(\Request::get('assign_id'));
        $volunteer = Volunteer::find(\Request::get('volunteer_id'));

        $statusId = VolunteerStatus::active();

        //change unit status to active
        VolunteerService::changeUnitStatus($volunteer->id, $action->unit_id, $statusId);

        $action->volunteers()->attach($volunteer);

        VolunteerService::actionHistory($volunteer->id, $action->id);

        return $volunteer->id;
    }

    /**
     * Remove volunteer from unit
     *
     * @param $volunteerId
     * @param $unitId
     * @return mixed
     */
    public function detachFromUnit($volunteerId, $unitId){
        $volunteer = Volunteer::findOrFail($volunteerId);

        $volunteer->units()->detach($unitId);

        return \Redirect::route('volunteer/one', ['id' => $volunteerId]);
    }

    /**
     * Remove volunteer from action
     *
     * @param $volunteerId
     * @param $actionId
     * @return mixed
     */
    public function detachFromAction($volunteerId, $actionId){

        $action = Action::find($actionId);

        $volunteer = Volunteer::findOrFail($volunteerId);

        $statusId = VolunteerStatus::available();

        //change unit status to active
        VolunteerService::changeUnitStatus($volunteer->id, $action->unit_id, $statusId);

        //detach from action
        $volunteer->actions()->detach($actionId);

        return \Redirect::route('volunteer/one', ['id' => $volunteerId]);
    }

    /**
     * Update the step status to the given status (Complete, Incomplete)
     *
     * @return mixed
     */
    public function updateStepStatus() {

        $stepStatusId = \Request::get('id');
        $status = \Request::get('status');
        $comments = \Request::get('comments');

        $stepStatus = VolunteerService::updateStepStatus($stepStatusId, $status, $comments);

        return $stepStatus->volunteer_id;
    }

    /**
     * Set volunteer status as blacklisted.
     * When a volunteer is blacklisted,
     * s/he is removed from all current actions and units.
     *
     * @return mixed
     */
    public function blacklisted() {

        $volunteer = Volunteer::findOrFail(\Request::get('id'));

        $volunteer->blacklisted = true;
        $volunteer->comments = \Request::get('comments');
        $volunteer->update();

        $volunteer->actions()->detach();
        $volunteer->units()->detach();

        return $volunteer->id;
    }

    /**
     * Set volunteer status as blacklisted
     *
     * @return mixed
     */
    public function unBlacklisted() {

        $volunteer = Volunteer::findOrFail(\Request::get('id'));

        $volunteer->blacklisted = false;
        $volunteer->comments = \Request::get('comments');
        $volunteer->update();

        return $volunteer->id;
    }

}
