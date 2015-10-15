<?php namespace Dependencies\ekpizo\services;


use App\Models\Descriptions\AvailabilityDay;
use App\Models\Volunteer;
use Interfaces\VolunteerInterface;

class VolunteerService implements VolunteerInterface {

    function save() {

        $volunteer = \Request::all();

        $isValid = $this->validate($volunteer);

        if ($isValid['failed'])
            return $isValid;
        else {

            $id = $this->store($volunteer);

            return $id;

        }


    }


    private function validate($volunteer) {

        //TODO: change this!!!! different fields for ekpizo, also check if id is null
        $validator = \Validator::make($volunteer, [
            'name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender_id' => 'required',
            'email' => 'required|email|unique:volunteers',
            'work_status_id' => 'required',
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
            'identification_type_id' => intval($volunteerRequest['identification_type_id']),
            'identification_num' => $volunteerRequest['identification_num'],
            'birth_date' => \Carbon::createFromFormat('d/m/Y', $volunteerRequest['birth_date'])->toDateString(),
            'gender_id' => intval($volunteerRequest['gender_id']),
            'marital_status_id' => intval($volunteerRequest['marital_status_id']),
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
            'education_level_id' => intval($volunteerRequest['education_level_id']),
            'specialty' => $volunteerRequest['specialty'],
            'department' => $volunteerRequest['department'],
            'driver_license_type_id' => intval($volunteerRequest['driver_license_type_id']),
            'computer_usage' => intval($volunteerRequest['computer_usage']),
            'additional_skills' => $volunteerRequest['additional_skills'],
            'extra_lang' => $volunteerRequest['extra_lang'],
            'work_status_id' => intval($volunteerRequest['work_status_id']),
            'work_description' => $volunteerRequest['work_description'],
            'participation_reason' => $volunteerRequest['participation_reason'],
            'participation_actions' => $volunteerRequest['participation_actions'],
            'participation_previous' => $volunteerRequest['participation_previous'],
            'availability_freqs_id' => intval($volunteerRequest['availability_freqs_id']),
            'comments' => $volunteerRequest['comments'],

            //extra fields
            'afm' => $volunteerRequest['afm'],
        ));

        //   return ($volunteer);

         $volunteer->save();

        $weekDays = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκεύη', 'Σαββατο', 'Κυριακή'];

        if ($volunteer->availability_freqs_id == "1") {
            $volunteer->availabilityTimes()->sync($volunteer->availability_freqs_id);
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

                        array_push($days, new AvailabilityDay([
                            'day' => $weekDay,
                            'time' => $time
                        ]));
                    }
                }
            }
            $volunteer->availabilityDays()->sync($days);

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

    }
}
