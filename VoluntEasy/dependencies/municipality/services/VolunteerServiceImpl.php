<?php namespace Dependencies\municipality\services;


use Interfaces\VolunteerServiceAbstract;

class VolunteerServiceImpl extends VolunteerServiceAbstract {


    /**
     * Validate the Volunteer
     */
    public function validate() {

        $volunteer = \Request::all();


        if (isset($volunteer['id']))
            $validator = \Validator::make($volunteer, [
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
     * Validate the Volunteer passed by the API
     */
    public function apiValidate(){
        $volunteer = \Request::all();

        $validator = \Validator::make($volunteer, [
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'fathers_name' => 'required|max:100',
            'identification_num' => 'max:100',
            'birth_date' => 'required|date',
            'children' => 'max:255',
            'address' => 'max:300',
            'city' => 'max:300',
            'country' => 'max:300',
            'post_box' => 'max:255',
            'afm' => 'max:100',
            'participation_reason' => 'required|max:600',
            'participation_previous' => 'max:600',
            'participation_actions' => 'max:600',
            'home_tel' => 'max:255',
            'work_tel' => 'max:255',
            'cell_tel' => 'max:255',
            'fax' => 'max:255',
            'gender_id' => 'required',
            'email' => 'required|email|unique:volunteers|max:255',
            'extra_lang' => 'max:300',
            'work_description' => 'max:600',
            'specialty' => 'max:300',
            'department' => 'max:300',
            'additional_skills' => 'max:300',
            'computer_usage_comments' => 'max:300',
            'comments' => 'max:6000',
            'contract_date' => 'date',
            'education_level_id' => 'required',
            'terms' => 'required',
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
        return false;
    }


    /**
     * Generate a Volunteer model from a Request
     */
    function getExtraFields($volunteer) {

        //            'work_status_id' => $this->checkDropDown($volunteerRequest['work_status_id']),
        /*
         *             'participation_reason' => $volunteerRequest['participation_reason'],
                    'participation_previous' => $volunteerRequest['participation_previous'],

         */
        $volunteer->work_status_id = \Request::get('how_you_learned_id');
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
