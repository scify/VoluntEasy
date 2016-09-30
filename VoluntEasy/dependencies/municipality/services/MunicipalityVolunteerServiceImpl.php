<?php namespace Dependencies\municipality\services;

use Dependencies\municipality\models\MunicipalityVolunteer;
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

class MunicipalityVolunteerServiceImpl extends VolunteerServiceImpl  {


    /**
     * Validate the Volunteer
     */
    public function validate() {
        // Call parent validate, keeping the result
        $parentResult = parent::validate();

        // Validate added fields, adding to the kept result
        $volunteer = \Request::all();
        // set integers when needed
        $volunteer['education_level_id'] = intval($volunteer['education_level_id']);
        $volunteer['work_status_id'] = intval($volunteer['work_status_id']);
        $validationRules = [
            'amka' => 'max:100',
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'fathers_name' => 'required|max:100',
            'identification_num' => 'max:100',
            'birth_date' => 'required',
            'address' => 'max:300',
            'city' => 'max:300',
            'country' => 'max:300',
            'post_box' => 'max:255',
            'participation_reason' => 'required|max:600',
            'participation_previous' => 'max:600',
            'participation_actions' => 'max:600',
            'home_tel' => 'max:255',
            'work_tel' => 'max:255',
            'cell_tel' => 'max:255',
            'gender_id' => 'required',
            'extra_lang' => 'max:300',
            'work_description' => 'max:600',
            'specialty' => 'max:300',
            'department' => 'max:300',
            'additional_skills' => 'max:300',
            'computer_usage_comments' => 'max:300',
            'comments' => 'max:6000',
            'education_level_id' => 'different:0',
            'work_status_id' => 'different:0',
            'other_education' => 'max:100',
        ];
        if (isset($volunteer['id'])) {
            $validationRules['email'] = 'required|email|max:255';
        } else {
            $validationRules['email'] = 'required|email|unique:volunteers|max:255';
        }
        $validator = \Validator::make($volunteer, $validationRules);
        if ($validator->fails()) {
            if (isset($parentResult['messages'])) {
                $parentResult['messages'] = array_merge($parentResult['messages']->toArray(),
                    $validator->messages()->toArray());
            } else {
                $parentResult['messages'] = $validator->messages()->toArray();
            }
            $parentResult['failed'] = true;
        }

        // Return overall validation
        return $parentResult;
    }

    /**
     * Validate public form
     * @return array
     */
    public function publicFormValidate() {
        $validationResult = $this->validate();
        $request = \Request::all();
        $validator = \Validator::make($request, [
            'terms' => 'required',
        ]);
        if ($validator->fails()) {
            if (isset($validationResult['messages'])) {
                $validationResult['messages'] = array_merge($validationResult['messages'],
                    $validator->messages()->toArray());
            } else {
                $validationResult['messages'] = $validator->messages()->toArray();
            }
            $validationResult['failed'] = true;
        }
        return $validationResult;
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
//        $volunteer->work_status_id = \Request::get('how_you_learned_id');
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
     * Save availability times to DB
     * @param $volunteer
     * @param $availabilityTimes
     */
    private function saveAvailabilityTimes($volunteer, $availabilityTimes) {
        if ($availabilityTimes != null && sizeof($availabilityTimes) > 0)
            $volunteer->availabilityTimes()->sync($availabilityTimes);
    }

    public function getPublicFormRequestToBecomeVolunteer($hide = 'true')
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
//        $viewPath = $this->configuration->getViewsPath() . '.public_form.volunteer_public_form';
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

        return view("municipality.resources.views.public_form.volunteer_public_form", compact(
            'identificationTypes', 'driverLicenseTypes', 'maritalStatuses', 'languages', 'langLevels',
            'workStatuses', 'availabilityFreqs', 'availabilityTimes', 'interestCategories', 'genders',
            'commMethod', 'edLevel', 'units', 'howYouLearned', 'hide'
        ));
    }

    /**
     * Override getBaseFields() to add more fields
     * @return array
     */
    public function getBaseFields() {
        $volunteerRequest = \Request::all();
        $baseFields = parent::getBaseFields();
        $baseFields['amka'] = $volunteerRequest['amka'];
        if(intval($volunteerRequest['education_level_id']) === sizeof(EducationLevel::all())) {
            $baseFields['other_education'] = $volunteerRequest['other_education'];
        } else {
            $baseFields['other_education'] = null;
        }

        //work_status_id cannot be 0 but is nullable
        if ($baseFields['work_status_id'] === '0') {
            $baseFields['work_status_id'] = null;
        }
        return $baseFields;
    }

    private function getAvailabilityTimes() {
        $volunteerRequest = \Request::all();
        $contributionTimes = array();
        if (isset($volunteerRequest['availability_times'])) {
            foreach ($volunteerRequest['availability_times'] as $contribution_time) {
                array_push($contributionTimes, intval($contribution_time));
            }
        }
        return $contributionTimes;
    }

    public function store() {

        $isValid = $this->validate();

        if (!$isValid['failed']) {
            $baseFields = $this->getBaseFields();
            $volunteer = new MunicipalityVolunteer($baseFields);

            if ($this->validate($volunteer)) {
                $volunteer->save();
                $volunteer = $this->basicStore($volunteer);
                $this->storeExtraFields($volunteer);
                $this->saveAvailabilityTimes($volunteer, $this->getAvailabilityTimes());
                return $volunteer;
            }
        } else
            return $isValid;
    }

    public function update($volunteer) {
        //TODO: Replace ALL this by simply overriding storeExtraFields

        // Check if fields are what they should be
        $isValid = $this->validate();

        // If so
        if (!$isValid['failed']) {

            // Get the base fields
            $baseFields = $this->getBaseFields();
            // and load the MunicipalityVolunteer from the DB
            $volunteer = MunicipalityVolunteer::findOrFail($volunteer->id);

            // Update the model
            $volunteer->update($baseFields);
            //store basic fields
            $this->basicStore($volunteer);
            //store extra fields
            $this->storeExtraFields($volunteer);
            $this->saveAvailabilityTimes($volunteer, $this->getAvailabilityTimes());
            return $volunteer;
        } else
            return $isValid;

    }

    public function postPublicFormRequestToBecomeVolunteer() {
        $isValid = $this->publicFormValidate();

        if (!$isValid['failed']) {
            $baseFields = $this->getBaseFields();
            $volunteer = new MunicipalityVolunteer($baseFields);

            $volunteer->save();
            $volunteer = $this->basicStore($volunteer);
            $this->storeExtraFields($volunteer);
            $this->saveAvailabilityTimes($volunteer, $this->getAvailabilityTimes());
            return $volunteer;
        } else
            return $isValid;
    }
}
