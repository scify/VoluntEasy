<?php namespace Dependencies\municipality\services;

use App\Models\Descriptions\Interest;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerLanguage;
use Interfaces\VolunteerInterface;

class VolunteerService implements VolunteerInterface {

    function save() {

        $volunteer = \Request::all();

        $isValid = $this->validate($volunteer);

        if ($isValid['failed'])
            return $isValid;
        else {
            $id = $this->store($volunteer);

            return [
                'failed' => false,
                'id' => $id];
        }
    }

    function update($volunteer) {
        $isValid = $this->validate($volunteer);

        if ($isValid['failed'])
            return $isValid;
        else {
            $volunteerRequest = \Request::all();

            $id = $this->doupdate($volunteer, $volunteerRequest);

            return [
                'failed' => false,
                'id' => $id];
        }
    }

    private function validate($volunteer) {

        if (isset($volunteer->id) && $volunteer->id != null && $volunteer->id != '')
            $validator = \Validator::make($volunteer->toArray(), [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'gender_id' => 'required',
                'email' => 'required|email',
                'participation_reason' => 'required']);

        else
            $validator = \Validator::make($volunteer, [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'gender_id' => 'required',
                'email' => 'required|email|unique:volunteers',
                'participation_reason' => 'required'
            ]);

        if ($validator->fails())
            return [
                'failed' => true,
                'messages' => $validator->messages()];
        else
            return [
                'failed' => false,
                'messages' => null];

    }

    private function store($volunteerRequest) {

        $live_in_curr_country = 0;
        if (isset($volunteerRequest['live_in_curr_country']) && $volunteerRequest['live_in_curr_country'] == 1)
            $live_in_curr_country = 1;

        $computer_usage = 0;
        if (isset($volunteerRequest['computer_usage']) && $volunteerRequest['live_in_curr_country'] == 1)
            $computer_usage = 1;

        $volunteer = new Volunteer([
            'name' => $volunteerRequest['name'],
            'last_name' => $volunteerRequest['last_name'],
            'fathers_name' => $volunteerRequest['fathers_name'],
            'identification_type_id' => $this->checkDropDown(intval($volunteerRequest['identification_type_id'])),
            'identification_num' => $volunteerRequest['identification_num'],
            'birth_date' => \Carbon::createFromFormat('d/m/Y', $volunteerRequest['birth_date'])->toDateString(),
            'gender_id' => $this->checkDropDown(intval($volunteerRequest['gender_id'])),
            'marital_status_id' => $this->checkDropDown(intval($volunteerRequest['marital_status_id'])),
            'children' => intval($volunteerRequest['children']),
            'address' => $volunteerRequest['address'],
            'post_box' => $volunteerRequest['post_box'],
            'city' => $volunteerRequest['city'],
            'country' => $volunteerRequest['country'],
            'live_in_curr_country' => $live_in_curr_country,
            'home_tel' => $volunteerRequest['home_tel'],
            'work_tel' => $volunteerRequest['work_tel'],
            'cell_tel' => $volunteerRequest['cell_tel'],
            'fax' => $volunteerRequest['fax'],
            'email' => $volunteerRequest['email'],
            'comm_method_id' => intval($volunteerRequest['comm_method_id']),
            'education_level_id' => $this->checkDropDown(intval($volunteerRequest['education_level_id'])),
            'specialty' => $volunteerRequest['specialty'],
            'department' => $volunteerRequest['department'],
            'driver_license_type_id' => $this->checkDropDown(intval($volunteerRequest['driver_license_type_id'])),
            'computer_usage' => $computer_usage,
            'additional_skills' => $volunteerRequest['additional_skills'],
            'extra_lang' => $volunteerRequest['extra_lang'],
            'work_status_id' => $this->checkDropDown(intval($volunteerRequest['work_status_id'])),
            'work_description' => $volunteerRequest['work_description'],
            'participation_reason' => $volunteerRequest['participation_reason'],
            'participation_actions' => $volunteerRequest['participation_actions'],
            'participation_previous' => $volunteerRequest['participation_previous'],
            'availability_freqs_id' => $this->checkDropDown(intval($volunteerRequest['availability_freqs_id'])),
            'comments' => $volunteerRequest['comments']
        ]);

        //   return ($volunteer);

        $volunteer->save();

        if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
            $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);

        $interests = Interest::all();

        // Get interests selected and pass values to volunteer_interests table.
        $interest_array = [];
        foreach ($interests as $interest) {
            if (isset($volunteerRequest['interest' . $interest->id])) {
                array_push($interest_array, $interest->id);
            }
        }

        $volunteer->interests()->sync($interest_array);

        $languages = Language::all();

        //Get all languages, and check if they are selected
        foreach ($languages as $language) {
            if (isset($volunteerRequest['lang' . $language->id])) {
                $level = LanguageLevel::where('id', $volunteerRequest['lang' . $language->id])->first();

                //create a new VolunteerLanguage that has
                $volLanguage = new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => $language->id,
                    'language_level_id' => $volunteerRequest['lang' . $language->id]
                ]);

                $volunteer->languages()->save($volLanguage);
            }
        }


        //get the selected users from the select2 array
        //and add them to an array
        if (isset($volunteerRequest['unitsSelect'])) {
            $unitsExcludes = [];

            foreach ($volunteerRequest['unitsSelect'] as $unit) {
                array_push($unitsExcludes, $unit);
            }

            $volunteer->unitsExcludes()->sync($unitsExcludes);
        }

        return $volunteer->id;
    }

    public function doupdate($volunteer, $volunteerRequest) {

        $live_in_curr_country = 0;
        if (isset($volunteerRequest['live_in_curr_country']) && $volunteerRequest['live_in_curr_country'] == 1)
            $live_in_curr_country = 1;

        $computer_usage = 0;
        if (isset($volunteerRequest['computer_usage']) && $volunteerRequest['computer_usage'] == 1)
            $computer_usage = 1;

        // update everything except middle table stuff
        $volunteer->update([
            'name' => $volunteerRequest['name'],
            'last_name' => $volunteerRequest['last_name'],
            'fathers_name' => $volunteerRequest['fathers_name'],
            'birth_date' => \Carbon::createFromFormat('d/m/Y', $volunteerRequest['birth_date'])->toDateString(),
            'identification_type_id' => $this->checkDropDown(intval($volunteerRequest['identification_type_id'])),
            'identification_num' => $volunteerRequest['identification_num'],
            'gender_id' => $this->checkDropDown(intval($volunteerRequest['gender_id'])),
            'marital_status_id' => $this->checkDropDown(intval($volunteerRequest['marital_status_id'])),
            'children' => intval($volunteerRequest['children']),
            'address' => $volunteerRequest['address'],
            'post_box' => $volunteerRequest['post_box'],
            'city' => $volunteerRequest['city'],
            'country' => $volunteerRequest['country'],
            'home_tel' => $volunteerRequest['home_tel'],
            'work_tel' => $volunteerRequest['work_tel'],
            'cell_tel' => $volunteerRequest['cell_tel'],
            'fax' => $volunteerRequest['fax'],
            'email' => $volunteerRequest['email'],
            'comm_method_id' => intval($volunteerRequest['comm_method_id']),
            'education_level_id' => $this->checkDropDown(intval($volunteerRequest['education_level_id'])),
            'specialty' => $volunteerRequest['specialty'],
            'department' => $volunteerRequest['department'],
            'driver_license_type_id' => $this->checkDropDown(intval($volunteerRequest['driver_license_type_id'])),
            'additional_skills' => $volunteerRequest['additional_skills'],
            'extra_lang' => $volunteerRequest['extra_lang'],
            'work_status_id' => $this->checkDropDown(intval($volunteerRequest['work_status_id'])),
            'work_description' => $volunteerRequest['work_description'],
            'participation_reason' => $volunteerRequest['participation_reason'],
            'participation_actions' => $volunteerRequest['participation_actions'],
            'participation_previous' => $volunteerRequest['participation_previous'],
            'availability_freqs_id' => $this->checkDropDown(intval($volunteerRequest['availability_freqs_id'])),
            'comments' => $volunteerRequest['comments'],
            'computer_usage' => $computer_usage,
            'live_in_curr_country' => $live_in_curr_country,
        ]);


        // update middle table relations

        if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
            $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
        else
            $volunteer->availabilityTimes()->detach();


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

            if ($langId && !in_array($language->id, $volunteerLanguages->lists('language_id')->all())) {
                //create a new VolunteerLanguage
                $volLanguage = new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => $language->id,
                    'language_level_id' => \Input::get('lang' . $language->id)
                ]);
                array_push($languages_array, $volLanguage);
            } else {
                VolunteerLanguage::where('volunteer_id', $volunteer->id)->where('language_id', $language->id)->delete();
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
        } else {
            $volunteer->unitsExcludes()->detach();
        }
    }

    private function checkDropDown($input) {
        if ($input == 0)
            return null;
        else
            return $input;
    }


    /**
     * Save data sent from another site
     *
     * @return mixed
     */
    function apiStore() {

        return \Input::all();

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
