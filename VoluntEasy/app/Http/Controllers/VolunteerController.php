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
use App\Models\Descriptions\StepStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerAvailabilityTime;
use App\Models\VolunteerLanguage;
use App\Models\VolunteerStepStatus;
use App\Services\Facades\UnitService;
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
        ));

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


        $volunteer = VolunteerService::setStatusToUnits($volunteer);


      / return $volunteer;

        return view("main.volunteers.show", compact('volunteer'));
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
            } else {
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
     * and also create the steps that are needed (status set to incomplete)
     *
     * @param $id
     */
    public function addToRootUnit($id) {

        $rootUnit = UnitService::getRoot();
        $rootUnit->load('steps');

        $volunteer = Volunteer::where('id', $id)->with('steps.status')->first();

        //check if the steps already exist
        if (sizeof(array_diff($rootUnit->steps->lists('id'), $volunteer->steps->lists('step_id')))) {

            $incompleteStatus = StepStatus::where('description', 'Incomplete')->first();

            //for each step of the unit, create a step, set its status to incomplete
            //and assign to volunteer
            $steps = [];
            foreach ($rootUnit->steps as $step) {
                array_push($steps, new VolunteerStepStatus([
                    'step_id' => $step->id,
                    'step_status_id' => $incompleteStatus->id
                ]));
            }
            $volunteer->steps()->saveMany($steps);
        }

        $rootUnit->volunteers()->attach($volunteer, ['volunteer_status_id' => VolunteerStatus::pending()]);

        return \Redirect::route('volunteer/one', ['id' => $id]);
    }

    /**
     * Add a volunteer to a unit
     * and also create the steps that are needed (status set to incomplete)
     *
     * @return mixed
     */
    public function addToUnit() {

        $unit = Unit::with('steps')->find(\Request::get('assign_id'));
        $volunteer = Volunteer::with('steps.status')->find(\Request::get('volunteer_id'));

        //check if the steps already exist
        if (sizeof(array_diff($unit->steps->lists('id'), $volunteer->steps->lists('step_id')))) {

            $incompleteStatus = StepStatus::where('description', 'Incomplete')->first();

            //for each step of the unit, create a step, set its status to incomplete
            //and assign to volunteer
            $steps = [];
            foreach ($unit->steps as $step) {
                array_push($steps, new VolunteerStepStatus([
                    'step_id' => $step->id,
                    'step_status_id' => $incompleteStatus->id
                ]));
            }
            $volunteer->steps()->saveMany($steps);
        }

        //also find the parent unit and remove the volunteer from it
        if(\Request::get('parent_unit_id')!='') {
            $parentUnit = Unit::find(\Request::get('parent_unit_id'));
            $parentUnit->volunteers()->detach($volunteer->id);
        }

        $unit->volunteers()->attach($volunteer, ['volunteer_status_id' => VolunteerStatus::pending()]);

        return $volunteer->id;
    }

    /**
     * Add a volunteer to a certain action
     *
     * @return mixed
     */
    public function addToAction() {

        $action = Action::find(\Request::get('assign_id'));
        $volunteer = Volunteer::find(\Request::get('volunteer_id'));

        $action->volunteers()->attach($volunteer);

        return $volunteer->id;
    }

    /**
     * For a current step, set the status to available.
     * If the current step is the last step (we assume assignment right now),
     * then also change the volunteer's unit's status to available.
     *
     * @return mixed
     */
    public function updateStepStatus() {

        $stepId = \Request::get('id');
        $statusId = StepStatus::where('description', \Request::get('status'))->first()->id;

        $stepStatus = VolunteerStepStatus::find($stepId);
        $stepStatus->comments = \Request::get('comments');
        $stepStatus->step_status_id = $statusId;
        $stepStatus->save();

        //if the last step is completed, then set the status of the volunteer to available
        if(\Request::has('available') && \Request::get('available')){

            //retrieve the current unit with the volunteer
            //base on step id
            $unit = Unit::with(['volunteers.steps' => function ($query) use ($stepId) {
                $query->where('id', $stepId);
            }])->first();

            $unit = $unit->volunteers()->where('volunteer_id', $stepStatus->volunteer_id)->first();

            //set volunteer status to available and save
            $unit->pivot->volunteer_status_id = VolunteerStatus::available();
            $unit->pivot->save();
        }

        return $stepStatus->volunteer_id;
    }

}
