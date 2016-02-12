<?php namespace Dependencies\ekpizo\services;


use App\Models\Descriptions\AvailabilityDay;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerLanguage;
use App\Services\Facades\NotificationService;
use App\Services\Facades\UnitService;
use Interfaces\VolunteerInterface;

class VolunteerService_OLD implements VolunteerInterface {

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

        //  dd(\Request::all());
        if (isset($volunteer->id) && $volunteer->id != null && $volunteer->id != '')
            $validator = \Validator::make($volunteer->toArray(), [
                'name' => 'required',
                'last_name' => 'required',
                'cell_tel' => 'required',
                'city' => 'required',
                'email' => 'required|email']);

        else
            $validator = \Validator::make($volunteer, [
                'name' => 'required',
                'last_name' => 'required',
                'cell_tel' => 'required',
                'city' => 'required',
                'email' => 'required|email|unique:volunteers'
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

    public function store() {
        /*
        $volunteer = new Volunteer(array(
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
            'live_in_curr_country' => intval($volunteerRequest['live_in_curr_country']),
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
            'computer_usage' => intval($volunteerRequest['computer_usage']),
            'additional_skills' => $volunteerRequest['additional_skills'],
            'extra_lang' => $volunteerRequest['extra_lang'],
            'work_status_id' => $this->checkDropDown(intval($volunteerRequest['work_status_id'])),
            'work_description' => $volunteerRequest['work_description'],
            'participation_reason' => $volunteerRequest['participation_reason'],
            'participation_actions' => $volunteerRequest['participation_actions'],
            'participation_previous' => $volunteerRequest['participation_previous'],
            'availability_freqs_id' => $this->checkDropDown(intval($volunteerRequest['availability_freqs_id'])),
            'comments' => $volunteerRequest['comments'],

            //extra fields
            'afm' => $volunteerRequest['afm'],
            'how_you_learned_id' => $this->checkDropDown($volunteerRequest['howYouLearned']),
            'computer_usage_comments' => $volunteerRequest['computer_usage_comments'],
        ));

        //   return ($volunteer);

        $volunteer->save();

        $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή'];

        if ($volunteer->availability_freqs_id == "1") {
            if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
                $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
        } else {

            $days = [];
            $time = '';

            foreach ($weekDays as $weekDay) {
                if (isset($volunteerRequest[$weekDay])) {
                    foreach ($volunteerRequest[$weekDay] as $availability) {

                        if ($availability == "1")
                            $time = 'Πρωί';
                        else if ($availability == "2")
                            $time = 'Μεσημέρι';
                        else if ($availability == "3")
                            $time = 'Απόγευμα';

                        $day = new AvailabilityDay([
                            'day' => $weekDay,
                            'time' => $time
                        ]);

                        $volunteer->availabilityDays()->save($day);
                    }
                }
            }
        }

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
            'live_in_curr_country' => intval($volunteerRequest['live_in_curr_country']),
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
            'computer_usage' => intval($volunteerRequest['computer_usage']),
            'additional_skills' => $volunteerRequest['additional_skills'],
            'extra_lang' => $volunteerRequest['extra_lang'],
            'work_status_id' => $this->checkDropDown(intval($volunteerRequest['work_status_id'])),
            'work_description' => $volunteerRequest['work_description'],
            'participation_reason' => $volunteerRequest['participation_reason'],
            'participation_actions' => $volunteerRequest['participation_actions'],
            'participation_previous' => $volunteerRequest['participation_previous'],
            'availability_freqs_id' => $this->checkDropDown(intval($volunteerRequest['availability_freqs_id'])),
            'comments' => $volunteerRequest['comments'],

            //extra fields
            'afm' => $volunteerRequest['afm'],
            'how_you_learned_id' => $this->checkDropDown($volunteerRequest['howYouLearned']),
            'computer_usage_comments' => $volunteerRequest['computer_usage_comments'],
        ]);


        // update middle table relations
        $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή'];

        if ($volunteer->availability_freqs_id == "1") {
            if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
                $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
            else
                $volunteer->availabilityTimes()->detach();
        } else {
            $volunteer->availabilityDays()->detach();

            $days = [];
            $time = '';

            foreach ($weekDays as $weekDay) {
                if (isset($volunteerRequest[$weekDay])) {
                    foreach ($volunteerRequest[$weekDay] as $availability) {

                        if ($availability == "1")
                            $time = 'Πρωί';
                        else if ($availability == "2")
                            $time = 'Μεσημέρι';
                        else if ($availability == "3")
                            $time = 'Απόγευμα';

                        $day = new AvailabilityDay([
                            'day' => $weekDay,
                            'time' => $time
                        ]);

                        $volunteer->availabilityDays()->save($day);
                    }
                }
            }
        }

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
        }*/
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
    public function apiStore() {

        $data = \Request::get('submitted');

        //return $this->validateInput($data);
        //first validate input
        $validate = $this->validateInput($data);

        if ($validate==0) {

            $volunteer = new Volunteer(array(
                'name' => $data['volunteer_info']['name'],
                'last_name' => $data['volunteer_info']['last_name'],
                'fathers_name' => $data['volunteer_info']['fathers_name'],
                'city' => $data['volunteer_info']['city'],
                'country' => $data['volunteer_info']['country'],
                'gender_id' => $this->checkDropDown($data['volunteer_info']['gender_id']),
                'driver_license_type_id' => $this->checkDropDown($data['volunteer_info']['driver_license_type_id']),

                'home_tel' => $data['volunteer_info']['home_tel'],
                'cell_tel' => $data['volunteer_info']['cell_tel'],
                'email' => $data['volunteer_info']['email'],

                'education_level_id' => $this->checkDropDown($data['education']['education_level_id']),
                'specialty' => $data['education']['specialty'],
                'additional_skills' => $data['education']['additional_skills'],
                'computer_usage_comments' => $data['education']['computer_usage_comments'],
                'extra_lang' => $data['education']['languages']['extra_lang'],

                'availability_freqs_id' => $this->checkDropDown($data['avail_Inter']['availability_freqs_id']),

                'work_description' => $data['work_exper']['job_experience_comments'],
                'participation_actions' => $data['work_exper']['vol_experience_area'],
                'other_department' => $data['volunteering']['other_department'],

                'how_you_learned_id' => $this->checkDropDown($data['extra_comments']['howYouLearned']),
                'how_you_learned2_id' => $this->checkDropDown($data['extra_comments']['how_did_you_learn']),
            ));

            //Birthday
            if ($data['volunteer_info']['birth_date'] != null && $data['volunteer_info']['birth_date'] != ""
                && $data['volunteer_info']['birth_date']['year'] != null && $data['volunteer_info']['birth_date']['year'] != ""
                && $data['volunteer_info']['birth_date']['month'] != null && $data['volunteer_info']['birth_date']['month'] != ""
                && $data['volunteer_info']['birth_date']['day'] != null && $data['volunteer_info']['birth_date']['day'] != ""
            )
                $volunteer->birth_date = \Carbon::createFromDate($data['volunteer_info']['birth_date']['year'], $data['volunteer_info']['birth_date']['month'], $data['volunteer_info']['birth_date']['day']);

            $volunteer->save();


            //word, excel, powerpoint
            if (isset($data['education']['office']['office_word']) && $data['education']['office']['office_word'] == 1)
                $volunteer->extras()->knows_office = 1;
            if (isset($data['education']['office']['office_excel']) && $data['education']['office']['office_excel'] == 1)
                $volunteer->extras()->knows_excel = 1;
            if (isset($data['education']['office']['office_powerpoint']) && $data['education']['office']['office_powerpoint'] == 1)
                $volunteer->extras()->knows_excel = 1;

            if (isset($data['work_exper']['vol_experience']) && $data['work_exper']['vol_experience'] == 1)
                $volunteer->extras()->has_previous_volunteer_experience = 1;
            if (isset($data['work_exper']['job_experience']) && $data['work_exper']['job_experience'] == 1)
                $volunteer->extras()->has_has_previous_work_experience = 1;


            //Languages
            if (isset($data['languages']['langGR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('Ελληνικά', $data['languages']['langGR'], $volunteer->id));
            if (isset($data['languages']['langGR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('Αγγλικά', $data['languages']['langGR'], $volunteer->id));
            if (isset($data['languages']['langFR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('Γαλλικά', $data['languages']['langFR'], $volunteer->id));
            if (isset($data['languages']['langSP']))
                $volunteer->languages()->save($this->createVolunteerLanguage('Ισπανικά', $data['languages']['langSP'], $volunteer->id));
            if (isset($data['languages']['langDE']))
                $volunteer->languages()->save($this->createVolunteerLanguage('Γερμανικά', $data['languages']['langDE'], $volunteer->id));


            //Interests
            $volunteer->interests()->sync($data['avail_Inter']['interests']);

            //Volunteering Departments
            if (isset($data['volunteering']['department']))
                $volunteer->volunteeringDepartments()->sync($data['volunteering']['department']);

            //Availability
            if (isset($data['avail_Inter']['availability_freqs_id']) && $data['avail_Inter']['availability_freqs_id'] != "") {

                if ($data['avail_Inter']['availability_freqs_id'] == "1") {

                    if (isset($data['avail_Inter']['dailyFrequencies']) && sizeof($data['avail_Inter']['dailyFrequencies']) > 0)
                        $volunteer->availabilityTimes()->sync($data['avail_Inter']['dailyFrequencies']);

                } else {
                    if (isset($data['avail_Inter']['contr_days']) && sizeof($data['avail_Inter']['contr_days']) > 0) {

                        $weekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        $time = '';

                        foreach ($weekDays as $weekDay) {
                            if (isset($data['avail_Inter']['contr_days'][$weekDay])) {
                                foreach ($data['avail_Inter']['contr_days'][$weekDay] as $availability) {

                                    if ($availability == "1")
                                        $time = 'Πρωί';
                                    else if ($availability == "2")
                                        $time = 'Μεσημέρι';
                                    else if ($availability == "3")
                                        $time = 'Απόγευμα';

                                    switch ($weekDay) {
                                        case 'monday':
                                            $day = 'Δευτέρα';
                                            break;
                                        case 'tuesday':
                                            $day = 'Τρίτη';
                                            break;
                                        case 'wednesday':
                                            $day = 'Τετάρτη';
                                            break;
                                        case 'thursday':
                                            $day = 'Πέμπτη';
                                            break;
                                        case 'friday':
                                            $day = 'Παρασκεύη';
                                            break;
                                        case 'saturday':
                                            $day = 'Σάββατο';
                                            break;
                                        case 'sunday':
                                            $day = 'Κυριακή';
                                            break;
                                    }
                                    $day = new AvailabilityDay([
                                        'day' => $day,
                                        'time' => $time
                                    ]);

                                    $volunteer->availabilityDays()->save($day);
                                }
                            }
                        }
                    }
                }
            }

            NotificationService::newVolunteer($volunteer->id, UnitService::getRoot()->id);

            return \Response::json($volunteer, 201);
        } else {
            return \Response::json($validate, 200);
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
    private
    function createVolunteerLanguage($language, $level, $volunteerId) {
        $languageId = Language::where('description', $language)->first(['id'])->id;

        $volLanguage = new VolunteerLanguage([
            'volunteer_id' => $volunteerId,
            'language_id' => $languageId,
            'language_level_id' => $level
        ]);

        return $volLanguage;
    }


    /**
     * Validate form input before taking any action.
     * Return error codes in order to display appropriate message to the front end.
     *
     * @return bool
     */
    private function validateInput($data) {

        if (!isset($data['volunteer_info']['name']) || $data['volunteer_info']['name'] == '')
            return 101;

        if (!isset($data['volunteer_info']['last_name']) || $data['volunteer_info']['last_name'] == '')
            return 102;

        if ($data['volunteer_info']['birth_date'] == null || $data['volunteer_info']['birth_date'] == ""
            || $data['volunteer_info']['birth_date']['year'] == null || $data['volunteer_info']['birth_date']['year'] == ""
            || $data['volunteer_info']['birth_date']['month'] == null || $data['volunteer_info']['birth_date']['month'] == ""
            || $data['volunteer_info']['birth_date']['day'] == null || $data['volunteer_info']['birth_date']['day'] == ""
        )
            return 103;

        $emails = Volunteer::where('email', $data['volunteer_info']['email'])->get();

        if (!isset($data['volunteer_info']['email']) || $data['volunteer_info']['email'] == ''
            || !filter_var($data['volunteer_info']['email'], FILTER_VALIDATE_EMAIL)
        )
            return 201;
        if (sizeof($emails) > 0)
            return 202;

        return 0;
    }
}