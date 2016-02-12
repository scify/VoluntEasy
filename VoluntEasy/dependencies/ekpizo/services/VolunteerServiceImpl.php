<?php namespace Dependencies\ekpizo\services;


use Interfaces\VolunteerServiceAbstract;

class VolunteerServiceImpl extends VolunteerServiceAbstract {


    /**
     * Validate the Volunteer
     *
     */
    function validate() {

        $volunteer = \Request::all();

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
        $volunteer->how_you_learned_id = \Request::get('how_you_learned_id');
        $volunteer->computer_usage_comments = \Request::get('computer_usage_comments');
        $volunteer->extras()->knows_word = \Request::get('knows_word');
        $volunteer->extras()->knows_excel = \Request::get('knows_excel');
        $volunteer->extras()->knows_powerpoint = \Request::get('knows_powerpoint');
        $volunteer->extras()->has_previous_volunteer_experience = \Request::get('has_previous_volunteer_experience');
        $volunteer->extras()->has_previous_work_experience = \Request::get('has_previous_work_experience');
        $volunteer->extras()->volunteering_work_extra = \Request::get('volunteering_work_extra');
        $volunteer->extras()->other_department = \Request::get('other_department');

        return $volunteer;
    }

    /**
     * Store extra volunter fields
     * @param $volunteer
     * @return null|void
     */
    function storeExtraFields($volunteer) {

        $this->saveFrequencies($volunteer);

    }


    /**
     * Save volunteer frequencies
     *
     * @param $volunteer
     */
    private function saveFrequencies($volunteer) {

        if ($volunteer->availability_freqs_id == "1") {
            if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
                $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
        } else {
            $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή'];

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
    }
}
