<?php

namespace Interfaces;

use App\Models\Descriptions\AvailabilityDay;
use App\Models\Volunteer;
use App\Models\VolunteerExtras;

/**
 * The volunteer form with the "extras" (office skills, experience,
 * volunteering departments, availability), as the scify and ekpizo
 * deployment flavours use it.
 */
class StandardVolunteerService extends VolunteerServiceAbstract {

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
     * Store extra volunter fields
     * @param $volunteer
     * @return null|void
     */
    function storeExtraFields($volunteer) {

        $this->saveFrequencies($volunteer);

        if (\Request::filled('departments'))
            $volunteer->volunteeringDepartments()->sync(\Request::get('departments'));

        if (\Request::filled('has_previous_volunteer_experience') && \Request::get('has_previous_volunteer_experience') == 'on')
            $has_previous_volunteer_experience = true;
        else
            $has_previous_volunteer_experience = false;
        if (\Request::filled('has_previous_work_experience') && \Request::get('has_previous_work_experience') == 'on')
            $has_previous_work_experience = true;
        else
            $has_previous_work_experience = false;

        if (\Request::filled('howYouLearned') && \Request::get('howYouLearned') != 0)
            $volunteer->how_you_learned_id = \Request::get('howYouLearned');
        if (\Request::filled('howYouLearned2') && \Request::get('howYouLearned2') != 0)
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
    protected function saveFrequencies($volunteer) {

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
                if (\Request::filled($weekDay)) {
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
}
