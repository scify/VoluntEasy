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

    public function actions() {
        return $this->belongsToMany('App\Models\Action', 'actions_volunteers', 'volunteer_id');
    }

    public function availabilityDays() {
        return $this->hasMany('App\Models\Descriptions\AvailabilityDay', 'volunteer_id');
    }

    public function languages() {
        return $this->hasMany('App\Models\VolunteerLanguage', 'volunteer_id');
    }

    public function units() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status', 'volunteer_id');
    }

    public function unitsExcludes() {
        return $this->belongsToMany('App\Models\Unit', 'volunteers_units_excludes', 'volunteer_id');
    }

    public function unitsPivot() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status', 'volunteer_id')->withPivot('volunteer_status_id');
    }

    public function unitsStatus() {
        return $this->hasMany('App\Models\VolunteerUnitStatus', 'volunteer_id')->withTrashed();
    }

    public function steps() {
        return $this->hasMany('App\Models\VolunteerStepStatus', 'volunteer_id');
    }

    public function files() {
        return $this->hasMany('App\Models\File', 'volunteer_id');
    }

    public function opaRatings() {
        return $this->hasMany('App\Models\OPARating\VolunteerRating', 'volunteer_id')->withTrashed();
    }

    public function statusDuration() {
        return $this->hasMany('App\Models\Descriptions\VolunteerStatusDuration', 'volunteer_id');
    }
}
