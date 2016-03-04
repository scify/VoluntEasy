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
use App\Models\Descriptions\HowYouLearned;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\VolunteeringDepartment;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\VolunteerStatusDuration;
use App\Models\Descriptions\WorkStatus;
use App\Models\File;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerAvailabilityTime;
use App\Models\VolunteerLanguage;
use App\Services\Facades\RatingService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use DB;
use Illuminate\Support\Facades\Session;

class VolunteerController extends Controller {

    private $configuration;
    private $volunteerService;

    public function __construct() {
        $this->middleware('auth', ['except' => ['publicForm']]);
        $this->configuration =  \App::make('Interfaces\ConfigurationInterface');
        $this->volunteerService =  \App::make('Interfaces\VolunteerInterface');

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

        $identificationTypes = IdentificationType::lists('description', 'id')->all();
        $driverLicenseTypes = DriverLicenceType::lists('description', 'id')->all();
        $maritalStatuses = MaritalStatus::lists('description', 'id')->all();
        $languages = Language::lists('description', 'id')->all();
        $langLevels = LanguageLevel::lists('description', 'id')->all();
        $workStatuses = WorkStatus::lists('description', 'id')->all();
        $availabilityFreqs = AvailabilityFrequencies::lists('description', 'id')->all();
        $availabilityTimes = AvailabilityTime::lists('description', 'id')->all();
        $interestCategories = InterestCategory::with('interests')->get()->all();
        $genders = Gender::lists('description', 'id')->all();
        $commMethod = CommunicationMethod::lists('description', 'id')->all();
        $edLevel = EducationLevel::lists('description', 'id')->all();
        $howYouLearned = HowYouLearned::lists('description', 'id')->all();
        $units = Unit::orderBy('description', 'asc')->get()->all();
        $volunteeringDepartments = VolunteeringDepartment::get()->all();

        //The extras are the add-on features based on the needs.
        $extras = $this->configuration->getExtras();
        $extrasPath = $this->configuration->getExtrasPath();

        $maritalStatuses[0] = '[- επιλέξτε -]';
        $edLevel[0] = '[- επιλέξτε -]';
        $genders[0] = '[- επιλέξτε -]';
        $identificationTypes[0] = '[- επιλέξτε -]';
        $driverLicenseTypes[0] = '[- επιλέξτε -]';
        $workStatuses[0] = '[- επιλέξτε -]';
        $availabilityFreqs[0] = '[- επιλέξτε -]';
        $howYouLearned[0] = '[- επιλέξτε -]';
        ksort($maritalStatuses);
        ksort($edLevel);
        ksort($genders);
        ksort($identificationTypes);
        ksort($driverLicenseTypes);
        ksort($workStatuses);
        ksort($availabilityFreqs);
        ksort($howYouLearned);

        return view('main.volunteers.create', compact('identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders', 'commMethod', 'edLevel', 'volunteeringDepartments', 'units', 'howYouLearned', 'extras', 'extrasPath'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

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

                    return \Redirect::back()->withInput();
                }
                //if file exceeds mazimum allowed size, redirect back with error message
                if ($file->getSize() > 10000000) {
                    \Session::flash('flash_message', 'Το αρχείο ' . $file->getClientOriginalName() . ' ξεπερνά σε μέγεθος τα 10mb.');
                    \Session::flash('flash_type', 'alert-danger');

                    return \Redirect::back()->withInput();
                }
            }
        }

        $saved = $this->volunteerService->store();

        if($saved['failed'])
            return redirect()->back()->withErrors($saved['messages'])->withInput();


        if ($files != null && sizeof($files) > 0 && $flag == true)
            VolunteerService::storeFiles(\Input::file('files'), $saved->id);


        return \Redirect::route('volunteer/profile', ['id' => $saved->id]);
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
        $totalWorkingHours = VolunteerService::totalWorkingHours($timeline);
        $totalRatings = RatingService::totalVolunteerRating($timeline);
        $actionsRatings = VolunteerService::actionsRatings($id);

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

        $actionsCount = 0;
        foreach ($timeline as $block) {
            if ($block->type == 'action')
                $actionsCount++;
        }

        $extras = $this->configuration->getExtras();

        return view('main.volunteers.show', compact('volunteer', 'pending', 'available', 'timeline', 'userUnits', 'actionsCount', 'actionsRatings', 'totalRatings', 'totalWorkingHours', 'partialsPath'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $volId
     * @return Response
     */
    public function edit($volId) {
        $volunteer = Volunteer::with('interests', 'availabilityTimes', 'availabilityDays', 'unitsExcludes', 'files', 'extras', 'volunteeringDepartments')->findOrFail($volId);

        $identificationTypes = IdentificationType::lists('description', 'id')->all();
        $driverLicenseTypes = DriverLicenceType::lists('description', 'id')->all();
        $maritalStatuses = MaritalStatus::lists('description', 'id')->all();
        $languages = Language::lists('description', 'id')->all();
        $langLevels = LanguageLevel::lists('description', 'id')->all();
        $workStatuses = WorkStatus::lists('description', 'id')->all();
        $availabilityFreqs = AvailabilityFrequencies::lists('description', 'id')->all();
        $availabilityTimes = AvailabilityTime::lists('description', 'id')->all();
        $interestCategories = InterestCategory::with('interests')->get();
        $genders = Gender::lists('description', 'id')->all();
        $commMethod = CommunicationMethod::lists('description', 'id')->all();
        $howYouLearned = HowYouLearned::lists('description', 'id')->all();
        $edLevel = EducationLevel::lists('description', 'id')->all();
        $volunteeringDepartments = VolunteeringDepartment::get()->all();

        //get the language levels in a readable array
        $lang_levels = [];
        foreach($volunteer->languages as $language){
            $lang_levels[$language->language->description] = $language->level->id;
        }

        $volunteer->lang_levels = $lang_levels;

        $units = Unit::orderBy('description', 'asc')->get();

        $maritalStatuses[0] = '[- επιλέξτε -]';
        $edLevel[0] = '[- επιλέξτε -]';
        $genders[0] = '[- επιλέξτε -]';
        $identificationTypes[0] = '[- επιλέξτε -]';
        $driverLicenseTypes[0] = '[- επιλέξτε -]';
        $workStatuses[0] = '[- επιλέξτε -]';
        $availabilityFreqs[0] = '[- επιλέξτε -]';
        $howYouLearned[0] = '[- επιλέξτε -]';
        ksort($maritalStatuses);
        ksort($edLevel);
        ksort($genders);
        ksort($identificationTypes);
        ksort($driverLicenseTypes);
        ksort($workStatuses);
        ksort($availabilityFreqs);
        ksort($howYouLearned);

        //The extras are the add-on features based on the needs.
        $extras = $this->configuration->getExtras();
        $extrasPath = $this->configuration->getExtrasPath();

        return view('main.volunteers.edit', compact('volunteer', 'identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders', 'commMethod', 'edLevel', 'volunteeringDepartments', 'units', 'howYouLearned', 'extras', 'extrasPath'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update() {

        $volunteer = Volunteer::findOrFail(\Request::get('id'));

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

        $saved = $this->volunteerService->update($volunteer);

        if($saved['failed'])
            return redirect()->back()->withErrors($saved['messages'])->withInput();


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

        $volunteer->load('files');

        foreach($volunteer->files as $f) {
            $file = File::find($f->id);

            $filename = public_path() . '/assets/uploads/volunteers/' . $file->filename;

            //if the file exists, delete it from the filesystem
            if (file_exists($filename))
                unlink($filename);

            //delete the row from the db
            $file->delete();
        }

        $volunteer->update(['email' => $volunteer->email . '_deleted']);

        $volunteer->delete();

        Session::flash('flash_message', 'Ο εθελοντής διαγράφηκε.');
        Session::flash('flash_type', 'alert-success');


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

        VolunteerService::addToAction($volunteer, $action);

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

        //check if the unit has any actions, then detach the volunteer from them
        if (sizeof($unit->actions) > 0)
            $volunteer->actions()->detach($unit->actions->lists('id')->all());

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

        VolunteerService::removeFromAction($volunteer, $action);

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

    /**
     * Serve the volunteer public form
     *
     * @return \Illuminate\View\View
     */
    public function publicForm() {

        $identificationTypes = IdentificationType::lists('description', 'id')->all();
        $driverLicenseTypes = DriverLicenceType::lists('description', 'id')->all();
        $maritalStatuses = MaritalStatus::lists('description', 'id')->all();
        $languages = Language::lists('description', 'id')->all();
        $langLevels = LanguageLevel::lists('description', 'id')->all();
        $workStatuses = WorkStatus::lists('description', 'id')->all();
        $availabilityFreqs = AvailabilityFrequencies::lists('description', 'id')->all();
        $availabilityTimes = AvailabilityTime::lists('description', 'id')->all();
        $interestCategories = InterestCategory::with('interests')->get()->all();
        $genders = Gender::lists('description', 'id')->all();
        $commMethod = CommunicationMethod::lists('description', 'id')->all();
        $edLevel = EducationLevel::lists('description', 'id')->all();
        $howYouLearned = HowYouLearned::lists('description', 'id')->all();
        $units = Unit::orderBy('description', 'asc')->get()->all();

        $viewPath = $this->configuration->getViewsPath().'.volunteers._form';

        $maritalStatuses[0] = '[- επιλέξτε -]';
        $edLevel[0] = '[- επιλέξτε -]';
        $genders[0] = '[- επιλέξτε -]';
        $identificationTypes[0] = '[- επιλέξτε -]';
        $driverLicenseTypes[0] = '[- επιλέξτε -]';
        $workStatuses[0] = '[- επιλέξτε -]';
        $availabilityFreqs[0] = '[- επιλέξτε -]';
        $howYouLearned[0] = '[- επιλέξτε -]';
        ksort($maritalStatuses);
        ksort($edLevel);
        ksort($genders);
        ksort($identificationTypes);
        ksort($driverLicenseTypes);
        ksort($workStatuses);
        ksort($availabilityFreqs);
        ksort($howYouLearned);

        return view('main.volunteers.public_form', compact('identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders', 'commMethod', 'edLevel', 'units', 'howYouLearned', 'viewPath'));
    }


}
