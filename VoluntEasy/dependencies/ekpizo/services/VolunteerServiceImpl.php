<?php namespace Dependencies\ekpizo\services;


use App\Models\Descriptions\AvailabilityDay;
use App\Models\Descriptions\Language;
use App\Models\Volunteer;
use App\Models\VolunteerExtras;
use App\Models\VolunteerLanguage;
use App\Services\Facades\NotificationService;
use App\Services\Facades\UnitService;
use Interfaces\VolunteerServiceAbstract;

class VolunteerServiceImpl extends VolunteerServiceAbstract {


    /**
     * Validate the Volunteer
     *
     */
    function validate() {

        $volunteer = \Request::all();

        if (isset($volunteer['id']))
            $validator = \Validator::make($volunteer, [
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

    /**
     * Generate a Volunteer model from a Request
     */
    public function volunteerHasExtraFields() {
        return true;
    }

    /**
     * Get the extra fields
     */
    function getExtraFields($volunteer) {
    }

    /**
     * Store extra volunter fields
     * @param $volunteer
     * @return null|void
     */
    function storeExtraFields($volunteer) {

        $this->saveFrequencies($volunteer);

        if (\Request::has('departments'))
            $volunteer->volunteeringDepartments()->sync(\Request::get('departments'));

        if (\Request::has('has_previous_volunteer_experience') && \Request::get('has_previous_volunteer_experience') == 'on')
            $has_previous_volunteer_experience = true;
        else
            $has_previous_volunteer_experience = false;
        if (\Request::has('has_previous_work_experience') && \Request::get('has_previous_work_experience') == 'on')
            $has_previous_work_experience = true;
        else
            $has_previous_work_experience = false;

        if (\Request::has('howYouLearned') && \Request::get('howYouLearned') != 0)
            $volunteer->how_you_learned_id = \Request::get('howYouLearned');
        if (\Request::has('howYouLearned2') && \Request::get('howYouLearned2') != 0)
            $volunteer->how_you_learned2_id = \Request::get('howYouLearned2');
        $volunteer->computer_usage_comments = \Request::get('computer_usage_comments');
        $volunteer->afm = \Request::get('afm');

        $volunteer->update();

        $extras = $volunteer->extras ?: new VolunteerExtras();

        $extras->volunteer_id = $volunteer->id;
        $extras->knows_word = \Request::get('knows_word');
        $extras->knows_excel = \Request::get('knows_excel');
        $extras->knows_powerpoint = \Request::get('knows_powerpoint');
        $extras->has_previous_volunteer_experience = $has_previous_volunteer_experience;
        $extras->has_previous_work_experience = $has_previous_work_experience;
        $extras->volunteering_work_extra = \Request::get('volunteering_work_extra');
        $extras->other_department = \Request::get('other_department');

        $volunteer->extras()->save($extras);
        return $volunteer;
    }


    /**
     * Save volunteer frequencies
     *
     * @param $volunteer
     */
    private function saveFrequencies($volunteer) {

        if ($volunteer->availability_freqs_id == "1") {
            if (\Request::get('availability_time')) {
                $volunteer->availabilityTimes()->sync(\Request::get('availability_time'));
            }
        } else {
            $weekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            $days = [];
            $time = '';

            $volunteer->availabilityDays()->delete();

            foreach ($weekDays as $weekDay) {
                if (\Request::has($weekDay)) {
                    foreach (\Request::get($weekDay) as $availability) {

                        if ($availability == "1")
                            $time = 'morning';
                        else if ($availability == "2")
                            $time = 'afternoon';
                        else if ($availability == "3")
                            $time = 'evening';

                        $day = new AvailabilityDay([
                            'day' => $weekDay,
                            'time' => $time,
                            'volunteer_id' => $volunteer->id
                        ]);
                        $day->save();
                    }
                }
            }
        }
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

        if ($validate == 0) {

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

            $extras = new VolunteerExtras();
            //word, excel, powerpoint
            if (isset($data['education']['office']['office_word']) && $data['education']['office']['office_word'] == 1)
                $extras->knows_word = 1;
            if (isset($data['education']['office']['office_excel']) && $data['education']['office']['office_excel'] == 1)
                $extras->knows_excel = 1;
            if (isset($data['education']['office']['office_powerpoint']) && $data['education']['office']['office_powerpoint'] == 1)
                $extras->knows_powerpoint = 1;

            if (isset($data['work_exper']['vol_experience']) && $data['work_exper']['vol_experience'] == 1)
                $extras->has_previous_volunteer_experience = 1;
            if (isset($data['work_exper']['job_experience']) && $data['work_exper']['job_experience'] == 1)
                $extras->has_previous_work_experience = 1;

            $extras->other_department = $data['volunteering']['other_department'];

            $volunteer->extras()->save($extras);


            //Languages
            if (isset($data['education']['languages']['langGR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('greek', $data['education']['languages']['langGR'], $volunteer->id));
            if (isset($data['education']['languages']['langGR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('english', $data['education']['languages']['langEN'], $volunteer->id));
            if (isset($data['education']['languages']['langFR']))
                $volunteer->languages()->save($this->createVolunteerLanguage('french', $data['education']['languages']['langFR'], $volunteer->id));
            if (isset($data['education']['languages']['langSP']))
                $volunteer->languages()->save($this->createVolunteerLanguage('spanish', $data['education']['languages']['langSP'], $volunteer->id));
            if (isset($data['education']['languages']['langDE']))
                $volunteer->languages()->save($this->createVolunteerLanguage('german', $data['education']['languages']['langDE'], $volunteer->id));

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
                                        $time = 'morning';
                                    else if ($availability == "2")
                                        $time = 'afternoon';
                                    else if ($availability == "3")
                                        $time = 'evening';

                                    $day = new AvailabilityDay([
                                        'day' => $weekDay,
                                        'time' => $time,
                                        'volunteer_id' => $volunteer->id
                                    ]);
                                    $day->save();
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


    private function checkDropDown($input) {
        if ($input == 0)
            return null;
        else
            return $input;
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

        if (!isset($data['avail_Inter']['interests']) || sizeof($data['avail_Inter']['interests']) == 0)
            return 104;

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
