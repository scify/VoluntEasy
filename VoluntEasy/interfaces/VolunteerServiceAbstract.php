<?php namespace Interfaces;

use App\Models\Descriptions\Interest;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Volunteer;


/**
 * Class VolunteerServiceAbstract
 * @package Interfaces
 *
 * VolunteerServiceAbstract uses the Template method pattern in order to define
 * the basic functions needed for the crud operations, also offering some hooks
 * to implement non final functions.
 *
 * Public final functions define a general algorithm/behaviour for the whole class.
 * Public abstract function should be overriden in the classes that extend the Template.
 * Public functions have a default dehaviour and many be overriden by the classes that extend the Template.
 */
abstract class VolunteerServiceAbstract implements VolunteerInterface {


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

        if (isset($volunteerRequest['birth_date']) && $volunteerRequest['birth_date'] != null)
            $volunteer->birth_date = \Carbon::createFromFormat('d/m/Y', $volunteerRequest['birth_date'])->toDateString();

        $volunteer->live_in_curr_country = 0;
        if (isset($volunteerRequest['live_in_curr_country']) && $volunteerRequest['live_in_curr_country'] == 1)
            $volunteer->live_in_curr_country = 1;

        $volunteer->computer_usage = 0;
        if (isset($volunteerRequest['computer_usage']) && $volunteerRequest['live_in_curr_country'] == 1)
            $volunteer->computer_usage = 1;

        return $volunteer;
    }


    /**
     * The template method
     * Sets up a general algorithm for the whole class
     */
    public final function basicStore($volunteer) {

        $volunteer->save();

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

        return $volunteer;
    }

    /**
     * Store a Volunteer object.
     * First load a volunteer, check if the object has extra fields,
     * then validate it and store it.
     *
     * @return mixed
     */
    public final function store() {

        $isValid = $this->validate();

        if (!$isValid['failed']) {
            $volunteer = $this->getBaseVolunteer();

            if ($this->volunteerHasExtraFields())
                $volunteer = $this->getExtraFields($volunteer);


            if ($this->validate($volunteer)) {

                $volunteer = $this->basicStore($volunteer);
                $this->storeExtraFields($volunteer);

                return $volunteer;
            }
        } else
            return $isValid;
    }

    public function update($volunteer) {

    }

    public function apiStore() {

    }

    /**
     * Validate the Volunteer
     */
    abstract function validate();


    /**
     * Check whether the Volunteer has more fields than the basic ones.
     *
     * @return bool
     */
    public function volunteerHasExtraFields() {
        return false;
    }


    /**
     * Get a volunteer with extra fields
     *
     * @param volunteer
     */
    public function getExtraFields($volunteer) {
        return $volunteer;
    }

    /**
     * Store the extra volunteer fields.
     *
     * @param $volunteer
     * @return null
     */
    public function storeExtraFields($volunteer) {
        return null;
    }

    private function checkDropDown($input) {
        if ($input == 0)
            return null;
        else
            return $input;
    }

}
