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
