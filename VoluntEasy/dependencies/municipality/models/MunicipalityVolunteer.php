<?php

namespace Dependencies\municipality\models;

use \App\Models\Volunteer;

class MunicipalityVolunteer extends Volunteer
{
    public function __construct(array $attributes = []) {
        // First update fillable to ascertain all attributes are used
        $this->fillable = array_merge($this->fillable, ['amka', 'other_education']);
        parent::__construct($attributes);

    }

    public function languages() {
        return $this->hasMany('App\Models\VolunteerLanguage', 'volunteer_id');
    }

    public function unitsExcludes() {
        return $this->belongsToMany('App\Models\Unit', 'volunteers_units_excludes', 'volunteer_id');
    }
}
