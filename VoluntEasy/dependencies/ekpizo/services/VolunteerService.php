<?php namespace Dependencies\ekpizo\services;


use App\Models\Descriptions\AvailabilityDay;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerLanguage;
use Interfaces\VolunteerInterface;

class VolunteerService implements VolunteerInterface {

    function save() {

        $volunteer = \Request::all();

        $isValid = $this->validate($volunteer);

        if ($isValid['failed'])
            return $isValid;
        else {
            $id = $this->store($volunteer);

            return [
                'failed' => false,
                'id' => $id];
        }
    }

    function update($volunteer) {

        $isValid = $this->validate($volunteer);

        if ($isValid['failed'])
            return $isValid;
        else {
            $volunteerRequest = \Request::all();

            $id = $this->doupdate($volunteer, $volunteerRequest);

            return [
                'failed' => false,
                'id' => $id];
        }
    }


    private function validate($volunteer) {

        if (isset($volunteer->id) && $volunteer->id != null && $volunteer->id != '')
            $validator = \Validator::make($volunteer->toArray(), [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'cell_tel' => 'required',
                'city' => 'required',
                'email' => 'required|email',
                'participation_reason' => 'required']);

        else
            $validator = \Validator::make($volunteer, [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'cell_tel' => 'required',
                'city' => 'required',
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

    private function store($volunteerRequest) {
        $volunteer = new Volunteer(array(
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
            'comments' => $volunteerRequest['comments'],

            //extra fields
            'afm' => $volunteerRequest['afm'],
            'how_you_learned_id' => $this->checkDropDown($volunteerRequest['howYouLearned']),
            'computer_usage_comments' => $volunteerRequest['computer_usage_comments'],
        ));

        //   return ($volunteer);

        $volunteer->save();

        $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή'];

        if ($volunteer->availability_freqs_id == "1") {
            if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
                $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
        } else {

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

        return $volunteer->id;
    }

    public function doupdate($volunteer, $volunteerRequest) {


        // update everything except middle table stuff
        $volunteer->update([
            'name' => $volunteerRequest['name'],
            'last_name' => $volunteerRequest['last_name'],
            'fathers_name' => $volunteerRequest['fathers_name'],
            'birth_date' => \Carbon::createFromFormat('d/m/Y', $volunteerRequest['birth_date'])->toDateString(),
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
            'comments' => $volunteerRequest['comments'],

            //extra fields
            'afm' => $volunteerRequest['afm'],
            'how_you_learned_id' => $this->checkDropDown($volunteerRequest['howYouLearned']),
            'computer_usage_comments' => $volunteerRequest['computer_usage_comments'],
        ]);


        // update middle table relations
        $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή'];

        if ($volunteer->availability_freqs_id == "1") {
            if (isset($volunteerRequest['availability_time']) && sizeof($volunteerRequest['availability_time']) > 0)
                $volunteer->availabilityTimes()->sync($volunteerRequest['availability_time']);
            else
                $volunteer->availabilityTimes()->detach();
        } else {
            $volunteer->availabilityDays()->detach();

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

        $interests = Interest::all();

        // Get interests selected and pass values to volunteer_interests table.
        $interest_array = [];
        foreach ($interests as $interest) {
            if (\Input::has('interest' . $interest->id)) {
                array_push($interest_array, $interest->id);
            }
        }
        $volunteer->interests()->sync($interest_array);

        //Save languages + levels
        $volunteerLanguages = $volunteer->languages()->get();

        foreach ($volunteerLanguages as $language) {
            if (\Input::has('lang' . $language->language_id)) {
                $language->language_level_id = \Input::get('lang' . $language->language_id);
                $language->save();
            }
        }

        $languages = Language::all();
        $languages_array = [];
        //Get all languages, and check if they are selected
        foreach ($languages as $language) {
            $langId = \Input::has('lang' . $language->id);

            if ($langId && !in_array($language->id, $volunteerLanguages->lists('language_id'))) {
                //create a new VolunteerLanguage
                $volLanguage = new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => $language->id,
                    'language_level_id' => \Input::get('lang' . $language->id)
                ]);

                array_push($languages_array, $volLanguage);
            }
        }
        $volunteer->languages()->saveMany($languages_array);

        $units = Unit::all();

        //get the selected users from the select2 array
        //and add them to an array
        if (\Input::has('unitsSelect')) {
            $unitsExcludes = [];

            foreach (\Input::get('unitsSelect') as $unit) {
                array_push($unitsExcludes, $unit);
            }

            $volunteer->unitsExcludes()->sync($unitsExcludes);
        } else {
            $volunteer->unitsExcludes()->detach();
        }
    }

    private function checkDropDown($input) {
        if ($input == 0)
            return null;
        else
            return $input;
    }
}
