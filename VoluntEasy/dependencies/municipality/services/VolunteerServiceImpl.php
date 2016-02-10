<?php namespace Dependencies\municipality\services;


use Interfaces\VolunteerServiceAbstract;

class VolunteerServiceImpl extends VolunteerServiceAbstract {


    /**
     * Validate the Volunteer
     */
    public function validate() {

        $volunteer = \Request::all();

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

    /**
     * Generate a Volunteer model from a Request
     */
    function getExtraFields($volunteer) {

        return;
    }

    /**
     * Store extra volunter fields
     * @param $volunteer
     * @return null|void
     */
    function storeAvailabilityTimes($volunteer) {

        $this->saveFrequencies($volunteer);

    }


    /**
     * Save volunteer frequencies
     *
     * @param $volunteer
     */
    private function saveAvailabilityTimes($volunteer) {
        if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
            $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
    }
}
