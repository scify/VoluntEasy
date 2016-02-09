<?php namespace App\Templates;

/**
 * Class VolunteerTemplate
 * @package App\Templates
 *
 */
abstract class VolunteerTemplate {


    /**
     * Create a Volunteer object with all it's basic (common to all) fields.
     */
    public final function getBaseVolunteer() {

        $volunteerRequest = \Request::all();

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
            'comments' => $volunteerRequest['comments']
        ]);
    }


    /**
     * The template method
     * Sets up a general algorithm for the whole class
     */
    public final function store() {

        $volunteer = $this->getBaseVolunteer();
        //if volunteerExtraFields -> volunteer-this->extrafields
        if ($this->validate($volunteer)){

            //doStore($volunteer);

        }
    }

    public final function update() {


    }

    public final function apiStore() {

    }

    /**
     * Check whether the Volunteer is fat, ie. if the model
     * has more fields than the basic ones.
     *
     * @return bool
     */
    public function volunteerHasExtraFields() {
        return false;
    }

    /**
     * Validate the Volunteer
     *
     * @param $volunteer
     */
    abstract function validate($volunteer);


    /**
     * Generate a Volunteer model from a Request
     */
    abstract function getVolunteerFields();


    /****************************************************************************************************/

    /**
     * The primitive operation
     * This function must be overridded
     */
    abstract function processTitle($title);


    /**
     * The hook operation
     * This function may be overridden, but does nothing if it is not
     */
    function processAuthor($author) {
        return NULL;
    }

}
