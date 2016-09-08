<?php namespace Dependencies\municipality\services;

use Interfaces\VolunteerServiceAbstract;
use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\HowYouLearned;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\InterestCategory;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Unit;

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
        //todo: comment out?
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

    public function getPublicFormRequestToBecomeVolunteer()
    {
        //get all models for form
        $identificationTypes = IdentificationType::lists('description', 'id')->all();
        $driverLicenseTypes = DriverLicenceType::lists('description', 'id')->all();
        $maritalStatuses = MaritalStatus::lists('description', 'id')->all();
        $languages = Language::lists('description', 'id')->all();
        $langLevels = LanguageLevel::lists('description', 'id')->all();
        $workStatuses = WorkStatus::lists('description', 'id')->all();
        $availabilityFreqs = AvailabilityFrequencies::lists('description', 'id')->all();
        $availabilityTimes = AvailabilityTime::lists('description', 'id')->all();
        $interestCategories = InterestCategory::with('interests')->get()->all();
        $genders = Gender::lists('description', 'id')->all();
        $commMethod = CommunicationMethod::lists('description', 'id')->all();
        $edLevel = EducationLevel::lists('description', 'id')->all();
        $howYouLearned = HowYouLearned::lists('description', 'id')->all();
        $units = Unit::orderBy('description', 'asc')->get()->all();
//        $viewPath = $this->configuration->getViewsPath() . '.volunteers._form';
        $maritalStatuses[0] = trans('entities/search.choose');
        $edLevel[0] = trans('entities/search.choose');
        $genders[0] = trans('entities/search.choose');
        $driverLicenseTypes[0] = trans('entities/search.choose');
        $workStatuses[0] = trans('entities/search.choose');
        $availabilityFreqs[0] = trans('entities/search.choose');
        $howYouLearned[0] = trans('entities/search.choose');
        ksort($maritalStatuses);
        ksort($edLevel);
        ksort($genders);
        ksort($driverLicenseTypes);
        ksort($workStatuses);
        ksort($availabilityFreqs);
        ksort($howYouLearned);

        return view("tests.cityofathens", compact(
            'identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders',
            'commMethod', 'edLevel', 'units', 'howYouLearned'
        ));
    }

    /**
     * Validate the Volunteer passed by the API
     */
    public function publicFormValidate(){
        $volunteer = \Request::all();

        $validator = \Validator::make($volunteer, [
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'fathers_name' => 'required|max:100',
            'identification_num' => 'max:100',
            'birth_date' => 'required',
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
}
