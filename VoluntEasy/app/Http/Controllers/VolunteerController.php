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
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\VolunteerStatusDuration;
use App\Models\Descriptions\WorkStatus;
use App\Models\File;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerAvailabilityTime;
use App\Models\VolunteerLanguage;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use DB;
use Illuminate\Support\Facades\Session;

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
        return view('main.volunteers.list');
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
        $interestCategories = InterestCategory::with('interests')->get();
        $genders = Gender::all()->lists('description', 'id');
        $commMethod = CommunicationMethod::all()->lists('description', 'id');
        $edLevel = EducationLevel::all()->lists('description', 'id');
        $units = Unit::orderBy('description', 'asc')->get();

        return view('main.volunteers.create', compact('identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders', 'commMethod', 'edLevel', 'units'));
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
            'identification_type_id' => intval(\Input::get('identification_type_id')),
            'identification_num' => \Input::get('identification_num'),
            'birth_date' => \Carbon::createFromFormat('d/m/Y', \Input::get('birth_date'))->toDateString(),
            'gender_id' => intval(\Input::get('gender_id')),
            'marital_status_id' => intval(\Input::get('marital_status_id')),
            'children' => intval(\Input::get('children')),
            'address' => \Input::get('address'),
            'post_box' => \Input::get('post_box'),
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
            'comments' => \Input::get('comments')
        ));


        $volunteer->save();

        $availability_times = AvailabilityTime::all();

        $availability_array = [];
        foreach ($availability_times as $availability_time) {
            if (\Input::has('availability_time' . $availability_time->id)) {
                array_push($availability_array, $availability_time->id);
            }
        }

        $volunteer->availabilityTimes()->sync($availability_array);

        $interests = Interest::all();

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


        //get the selected users from the select2 array
        //and add them to an array
        if (\Input::has('unitsSelect')) {
            $unitsExcludes = [];

            foreach (\Input::get('unitsSelect') as $unit) {
                array_push($unitsExcludes, $unit);
            }

            $volunteer->unitsExcludes()->sync($unitsExcludes);
        }


        //check if files uploaded already exist
        $files = \Input::file('files');
        $flag = false;

        foreach ($files as $file) {
            if ($file != null) {
                $flag = true;
                $filename = public_path() . '/assets/uploads/volunteers/' . $file->getClientOriginalName();

                //if file already exists, redirect back with error message
                if (file_exists($filename)) {
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' υπάρχει ήδη.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }
                //if file exceeds mazimum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' ξεπερνά σε μέγεθος τα 10mb.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }
            }
        }

        if ($files != null && sizeof($files) > 0 && $flag == true)
            VolunteerService::storeFiles(\Input::file('files'), $volunteer->id);


        return \Redirect::route('volunteer/profile', ['id' => $volunteer->id]);
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

        // return $volunteer;
        // return $timeline;
        //get the count of pending and available units, used in the front end
        $pending = 0;
        $available = 0;
        foreach ($volunteer->units as $unit) {
            if ($unit->status == 'Pending')
                $pending++;
            else if ($unit->status == 'Available' || $unit->status == 'Active')
                $available++;
        }

        //check if the volunteer is permitted to be edited by the
        //currently logged in user
        $permittedVolunteers = UserService::permittedVolunteersIds();
        if (in_array($volunteer->id, $permittedVolunteers))
            $volunteer->permitted = true;
        else
            $volunteer->permitted = false;

        $userUnits = UserService::userUnits();

        return view("main.volunteers.show", compact('volunteer', 'pending', 'available', 'timeline', 'userUnits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($volId) {
        $volunteer = Volunteer::with('interests', 'availabilityTimes', 'unitsExcludes', 'files')->findOrFail($volId);

        $identificationTypes = IdentificationType::all()->lists('description', 'id');
        $driverLicenseTypes = DriverLicenceType::all()->lists('description', 'id');
        $maritalStatuses = MaritalStatus::all()->lists('description', 'id');
        $languages = Language::all()->lists('description', 'id');
        $langLevels = LanguageLevel::all()->lists('description', 'id');
        $workStatuses = WorkStatus::all()->lists('description', 'id');
        $availabilityFreqs = AvailabilityFrequencies::all()->lists('description', 'id');
        $availabilityTimes = AvailabilityTime::all()->lists('description', 'id');
        $interestCategories = InterestCategory::with('interests')->get();
        $genders = Gender::all()->lists('description', 'id');
        $commMethod = CommunicationMethod::all()->lists('description', 'id');
        $edLevel = EducationLevel::all()->lists('description', 'id');

        $units = Unit::orderBy('description', 'asc')->get();

        return view('main.volunteers.edit', compact('volunteer', 'identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders', 'commMethod', 'edLevel', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
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
                'birth_date' => \Carbon::createFromFormat('d/m/Y', \Input::get('birth_date'))->toDateString(),
                'identification_type_id' => intval(\Input::get('identification_type_id')),
                'identification_num' => \Input::get('identification_num'),
                'gender_id' => intval(\Input::get('gender_id')),
                'marital_status_id' => intval(\Input::get('marital_status_id')),
                'children' => intval(\Input::get('children')),
                'address' => \Input::get('address'),
                'post_box' => \Input::get('post_box'),
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

        $interests = Interest::all();

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

        $units = Unit::all();

        //get the selected users from the select2 array
        //and add them to an array
        if (\Input::has('unitsSelect')) {
            $unitsExcludes = [];

            foreach (\Input::get('unitsSelect') as $unit) {
                array_push($unitsExcludes, $unit);
            }

            $volunteer->unitsExcludes()->sync($unitsExcludes);
            //return $unitsExcludes;
        } else {
            $volunteer->unitsExcludes()->detach();
        }


        //check if files uploaded already exist
        $files = \Input::file('files');
        $flag = false;

        foreach ($files as $file) {
            if ($file != null) {
                $flag = true;
                $filename = public_path() . '/assets/uploads/volunteers/' . $file->getClientOriginalName();

                //if file already exists, redirect back with error message
                if (file_exists($filename)) {
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' υπάρχει ήδη.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }

                //if file exceeds maximum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' ξεπερνά σε μέγεθος τα 10mb.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back();
                }
            }
        }


        if ($files != null && sizeof($files) > 0 && $flag == true)
            VolunteerService::storeFiles(\Input::file('files'), $volunteer->id);


        return \Redirect::route('volunteer/profile', ['id' => $volunteer->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $volunteer = Volunteer::findOrFail($id);

        //if the volunteer has units, do not delete
        if (sizeof($volunteer->units) > 0) {
            Session::flash('flash_message', 'Ο εθελοντής ανήκει σε οργανωτική μονάδα και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
        }
        //if the volunteer has actions, do not delete
        if (sizeof($volunteer->actions) > 0) {
            Session::flash('flash_message', 'Ο εθελοντής είναι ενεργός σε δράση και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
        }

        Session::flash('flash_message', 'Ο εθελοντής διαγράφηκε.');
        Session::flash('flash_type', 'alert-success');

        $volunteer->delete();

        return;
    }

    /**
     * Search all volunteers and re-render the partial
     * that contains the table with the volunteer data.
     *
     * @return mixed
     */
    public function search() {
        $volunteers = VolunteerService::search();

        return $volunteers;

        /*   $view = View::make('main.volunteers.list')->with('volunteers', $volunteers);
           return $view->renderSections()['table'];*/
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
            return \Redirect::route('volunteer/profile', ['id' => $id]);
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
     * Remove volunteer from unit and form its actions
     *
     * @param $volunteerId
     * @param $unitId
     * @return mixed
     */
    public function detachFromUnit($volunteerId, $unitId) {
        $volunteer = Volunteer::findOrFail($volunteerId);
        $unit = Unit::with('actions')->findOrFail($unitId);

        $volunteer->actions()->detach($unit->actions->lists('id'));
        $volunteer->units()->detach($unitId);

        return \Redirect::route('volunteer/profile', ['id' => $volunteerId]);
    }

    /**
     * Remove volunteer from action
     *
     * @param $volunteerId
     * @param $actionId
     * @return mixed
     */
    public function detachFromAction($volunteerId, $actionId) {

        $action = Action::find($actionId);

        $volunteer = Volunteer::findOrFail($volunteerId);

        $statusId = VolunteerStatus::available();

        //change unit status to active
        VolunteerService::changeUnitStatus($volunteer->id, $action->unit_id, $statusId);

        //detach from action
        $volunteer->actions()->detach($actionId);

        return \Redirect::route('volunteer/profile', ['id' => $volunteerId]);
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
        $assignTo = \Request::get('assignTo');

        $stepStatus = VolunteerService::updateStepStatus($stepStatusId, $status, $comments, $assignTo);

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

    /**
     * Set the volunteer status to not available
     * for a period of time
     *
     * @return mixed
     */
    public function notAvailable() {

        //first update the volunteer status -> set it to not available
        $volunteer = Volunteer::findOrFail(\Request::get('id'));
        $volunteer->not_available = true;
        $volunteer->update();


        //then add the comments and dates to the table
        $statusId = VolunteerStatus::notAvailable();

        //set the dates to an appropriate format
        if (\Request::get('from') != '')
            $from = \Carbon::createFromFormat('d/m/Y', \Request::get('from'))->toDateString();
        else
            $from = '';

        if (\Request::get('to') != '')
            $to = \Carbon::createFromFormat('d/m/Y', \Request::get('to'))->toDateString();
        else
            $to = '';

        //create the obj and save it to db
        $volunteer_status_duration = new VolunteerStatusDuration([
            'volunteer_id' => \Request::get('id'),
            'from_date' => $from,
            'to_date' => $to,
            'comments' => \Request::get('comments'),
            'status_id' => $statusId,
        ]);

        $volunteer_status_duration->save();

        return \Request::get('id');
    }

    /**
     * Set volunteer to available again
     *
     * @return mixed
     */
    public function available() {

        return VolunteerService::setVolunteerToAvailable(\Request::get('id'));
    }

    /**
     * Delete a volunteer's file from db and from filesystem
     *
     * @return mixed
     */
    public function deleteFile() {
        $id = \Request::get('id');
        $file = File::find($id);

        $filename = public_path() . '/assets/uploads/volunteers/' . $file->filename;

        //if the file exists, delete it from the filesystem
        if (file_exists($filename))
            unlink($filename);

        //delete the row from the db
        $file->delete();

        return $filename;
    }

}
