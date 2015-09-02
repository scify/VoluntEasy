<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use App\Models\Descriptions\StepStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Volunteer;
use App\Models\VolunteerLanguage;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;

class VolunteerApiController extends Controller {

    public function all() {
        $volunteers = Volunteer::with('units', 'actions')->orderBy('name', 'ASC')->get();
        //$volunteers->setPath(\URL::to('/') . '/volunteers');

        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = VolunteerService::prepareForDataTable($volunteers);

        return ["data" => $data];
    }

    /**
     * Get volunteer by status
     *
     * @param $status
     * @return array
     */
    public function status($status) {
        $volunteers = [];

        if ($status == 'new')
            $volunteers = Volunteer::unassigned()->get();
        else if ($status == 'active')
            $volunteers = Volunteer::active()->get();
        else if ($status == 'available')
            $volunteers = Volunteer::available()->get();
        else if ($status == 'pending') {
            $pending = Volunteer::pending()->get();

            foreach ($pending as $volunteer) {
                $id = $volunteer->id;
                $pendingStatus = StepStatus::incomplete();
                $permittedUnits = UserService::userUnits();

                $volunteer = Volunteer::with(['units' => function ($q) use ($id, $pendingStatus, $permittedUnits) {
                    $q->whereIn('unit_id', $permittedUnits)->with(['steps' => function ($query) use ($id, $pendingStatus) {
                        $query->whereHas('statuses', function ($query) use ($id, $pendingStatus) {
                            $query->where('volunteer_id', $id)->where('step_status_id', $pendingStatus);
                        });
                    }]);
                }])->where('id', $id)->first();

                if (sizeof($volunteer->units) > 0 && VolunteerService::isPermitted($id))
                    array_push($volunteers, $volunteer);
            }
        }
        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = VolunteerService::prepareForDataTable($volunteers);

        return ["data" => $data];
    }

    public function show($id) {
        $volunteer = VolunteerService::fullProfile($id);
        $volunteer = VolunteerService::setStatusToUnits($volunteer);

        //get the count of pending and available units, used in the front end
        $pending = 0;
        $available = 0;
        foreach ($volunteer->units as $unit) {
            if ($unit->status == 'Pending')
                $pending++;
            else if ($unit->status == 'Available' || $unit->status == 'Active')
                $available++;
        }

        //chekc if the volunteer is permitted to be edited by the
        //currently logged in user
        $permittedVolunteers = UserService::permittedVolunteersIds();
        if (in_array($volunteer->id, $permittedVolunteers))
            $volunteer->permitted = true;
        else
            $volunteer->permitted = false;

        return $volunteer;
    }

    public function store() {

        // dd(\Request::all());

        //first validate input
        if ($this->validateInput()) {

            $volunteer = new Volunteer(array(
                'name' => \Input::get('Όνομα'),
                'last_name' => \Input::get('Επώνυμο'),
                'fathers_name' => \Input::get('Όνομα_Πατέρα'),
                'identification_num' => \Input::get('Ταυτότητα'),
                'children' => intval(\Input::get('Τέκνα')),
                'address' => \Input::get('Διεύθυνση'),
                'post_box' => \Input::get('Τ_Κ'),
                'city' => \Input::get('Πόλη'),
                'country' => \Input::get('Χώρα'),
                'home_tel' => \Input::get('Τηλέφωνο_Οικίας'),
                'work_tel' => \Input::get('Τηλέφωνο_Εργασίας'),
                'cell_tel' => \Input::get('Κινητό'),
                'fax' => \Input::get('Fax'),
                'email' => \Input::get('email'),
                'specialty' => \Input::get('Ειδικότητα'),
                'department' => \Input::get('Σχολή'),
                'additional_skills' => \Input::get('Πρόσθετες_ικανότητες'),
                'extra_lang' => \Input::get('Άλλες_γλώσες'),
                'work_description' => \Input::get('Εργασία'),
                'participation_reason' => \Input::get('Λόγος_συμετοχής'),
                'participation_actions' => \Input::get('Εθελοντικές_δράσεις'),
                'participation_previous' => \Input::get('Εθελοντική_οργάνωση'),
            ));


            $volunteer->birth_date = \Carbon::createFromDate(\Input::get('Ημερομηνία_Γέννησης')['year'], \Input::get('Ημερομηνία_Γέννησης')['month'], \Input::get('Ημερομηνία_Γέννησης')['day']);


            $gender = Gender::where('description', \Input::get('Φύλο'))->first(['id']);
            if ($gender == null)
                $volunteer->gender_id = 1;
            else
                $volunteer->gender_id = $gender->id;


            $education_level = EducationLevel::where('description', \Input::get('Επίπεδο_εκπαίδευσης'))->first(['id']);
            if ($education_level == null)
                $volunteer->$education_level_id = 1;
            else
                $volunteer->education_level_id = $education_level->id;


            $work_status = WorkStatus::where('description', \Input::get('Εργασιακή_κατάσταση'))->first(['id']);
            if ($work_status == null)
                $volunteer->$work_status_id = 1;
            else
                $volunteer->work_status_id = $work_status->id;


            $columnId = null;
            if (!\Input::has('Τύπος_Ταυτότητας') || \Input::get('Τύπος_Ταυτότητας') != '') {
                $result = IdentificationType::where('description', \Input::get('Τύπος_Ταυτότητας'))->first(['id']);

                if ($result != null || $result != '')
                    $columnId = $result->id;
            }
            $volunteer->identification_type_id = $columnId;


            $columnId = null;
            if (!\Input::has('Οικογενειακή_Κατάσταση') || \Input::get('Οικογενειακή_Κατάσταση') != '') {
                $result = MaritalStatus::where('description', \Input::get('Οικογενειακή_Κατάσταση'))->first(['id']);

                if ($result != null || $result != '')
                    $columnId = $result->id;
            }
            $volunteer->marital_status_id = $columnId;


            $columnId = null;
            if (!\Input::has('Τρόπος_επικοινωνίας') || \Input::get('Τρόπος_επικοινωνίας') != '') {
                if (\Input::get('Τρόπος_επικοινωνίας') == 'email')
                    $result = CommunicationMethod::where('description', 'Ηλεκτρονικό ταχυδρομείο')->first(['id']);
                else
                    $result = CommunicationMethod::where('description', \Input::get('Τρόπος_επικοινωνίας'))->first(['id']);

                if ($result != null || $result != '')
                    $columnId = $result->id;
            }
            $volunteer->comm_method_id = $columnId;


            $columnId = null;
            if (!\Input::has('Δίπλωμα_οδήγησης') || \Input::get('Δίπλωμα_οδήγησης') != '') {
                $result = DriverLicenceType::where('description', \Input::get('Δίπλωμα_οδήγησης'))->first(['id']);

                if ($result != null || $result != '')
                    $columnId = $result->id;
            }
            $volunteer->driver_license_type_id = $columnId;


            $columnId = null;
            if (!\Input::has('Συχνότητα_συνεισφοράς') || \Input::get('Συχνότητα_συνεισφοράς') != '') {
                $result = AvailabilityFrequencies::where('description', \Input::get('Συχνότητα_συνεισφοράς'))->first(['id']);

                if ($result != null || $result != '')
                    $columnId = $result->id;
            }
            $volunteer->availability_freqs_id = $columnId;


            if (\Input::get('Κάτοικος_Ελλάδας') == 'Είναι Κάτοικος Ελλάδας')
                $volunteer->live_in_curr_country = 1;
            else
                $volunteer->live_in_curr_country = 0;

             $volunteer->save();

            if (\Input::has('Ελληνικά')) {
                $volunteer->languages()->save($this->createVolunteerLanguage('Ελληνικά', \Input::get('Ελληνικά'), $volunteer->id));
            }
            if (\Input::has('Αγγλικά')) {
                $volunteer->languages()->save($this->createVolunteerLanguage('Αγγλικά', \Input::get('Αγγλικά'), $volunteer->id));
            }
            if (\Input::has('Γαλλικά')) {
                $volunteer->languages()->save($this->createVolunteerLanguage('Γαλλικά', \Input::get('Γαλλικά'), $volunteer->id));
            }
            if (\Input::has('Ισπανικά')) {
                $volunteer->languages()->save($this->createVolunteerLanguage('Ισπανικά', \Input::get('Ισπανικά'), $volunteer->id));
            }
            if (\Input::has('Γερμανικά')) {
                $volunteer->languages()->save($this->createVolunteerLanguage('Γερμανικά', \Input::get('Γερμανικά'), $volunteer->id));
            }

            if (\Input::has('Χρόνοι_συνεισφοράς')) {
                $times = \Input::get('Χρόνοι_συνεισφοράς');
                $availability_array = [];

                foreach ($times as $time) {
                    $availability_time = AvailabilityTime::where('description', $time)->first(['id'])->id;
                    array_push($availability_array, $availability_time);
                }

                $volunteer->availabilityTimes()->sync($availability_array);
            }

            return \Response::json($volunteer, 201);
        } else {
            return \Response::json('Error in form fields', 409);
        }
    }

    /**
     * Create a new VolunteerLanguage
     *
     * @param $language
     * @param $level
     * @param $volunteerId
     * @return VolunteerLanguage
     */
    private function createVolunteerLanguage($language, $level, $volunteerId) {

        $levelId = LanguageLevel::where('description', $level)->first(['id'])->id;
        $languageId = Language::where('description', $language)->first(['id'])->id;

        $volLanguage = new VolunteerLanguage([
            'volunteer_id' => $volunteerId,
            'language_id' => $languageId,
            'language_level_id' => $levelId
        ]);

        return $volLanguage;
    }


    /**
     * Validate form input before taking any action
     *
     * @return bool
     */
    private function validateInput() {
        $flag = true;

        if (!\Input::has('Όνομα') || \Input::get('Όνομα') == '')
            return false;

        if (!\Input::has('Επώνυμο') || \Input::get('Επώνυμο') == '')
            return false;

        if (!\Input::has('Ημερομηνία_Γέννησης')
            || \Input::get('Ημερομηνία_Γέννησης')['year'] == ''
            || \Input::get('Ημερομηνία_Γέννησης')['month'] == ''
            || \Input::get('Ημερομηνία_Γέννησης')['day'] == ''
        )
            return false;

        if (!\Input::has('Φύλο'))
            return false;

        $emails = Volunteer::where('email', \Input::get('email'))->get(['email']);
        if (sizeof($emails) > 0 || !\Input::has('email') || \Input::get('email') == '' || !filter_var(\Input::get('email'), FILTER_VALIDATE_EMAIL))
            return false;

        if (!\Input::has('Επίπεδο_εκπαίδευσης') || \Input::get('Επίπεδο_εκπαίδευσης') == 'select')
            return false;

        if (!\Input::has('Εργασιακή_κατάσταση') || \Input::get('Εργασιακή_κατάσταση') == 'select')
            return false;

        return $flag;
    }

}
