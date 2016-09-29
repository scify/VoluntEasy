<?php

namespace Dependencies\municipality\models;

use \App\Models\Volunteer;

class MunicipalityVolunteer extends Volunteer
{
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->fillable = ['name', 'last_name', 'fathers_name', 'identification_num',
            'birth_date', 'children', 'address', 'city', 'country', 'post_box',
            'participation_reason', 'participation_previous', 'participation_actions',
            'email', 'extra_lang', 'work_description', 'additional_skills', 'live_in_curr_country',
            'comments', 'gender_id', 'education_level_id', 'comm_method', 'identification_type_id',
            'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id',
            'home_tel', 'work_tel', 'cell_tel', 'fax', 'comm_method_id', 'specialty', 'department',
            'computer_usage', 'availability_time', 'interests', 'blacklisted', 'not_available',
            'how_you_learned_id', 'how_you_learned2_id', 'computer_usage_comments', 'afm', 'contract_date', 'amka'];

    }

    public function languages() {
        return $this->hasMany('App\Models\VolunteerLanguage', 'volunteer_id');
    }
}
