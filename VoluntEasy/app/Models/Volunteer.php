<?php namespace App\Models;


class Volunteer extends User
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteers';

    protected $fillable = ['name', 'fathers_name', 'last_name', 'email', 'identification_num', 'birth_date', 'gender_id', 'education_level_id', 'participation_reason', 'extra_lang', 'comments', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id'];


    public function actions()
    {
        return $this->belongsToMany('App\Models\Action', 'actions_volunteers');
    }

    public function availabilityTimes()
    {
        return $this->belongsToMany('App\Models\Descriptions\AvailabilityTime', 'volunteer_availability_times', 'volunteer_id', 'availability_time_id');
    }

    public function availabilityFrequencies()
    {
        return $this->hasOne('App\Models\Descriptions\AvailabilityFrequencies', 'id', 'availability_freqs_id');
    }

    public function driverLicenceType()
    {
        return $this->hasOne('App\Models\Descriptions\DriverLicenceType', 'id', 'driver_license_type_id');
    }

    public function identificationType()
    {
        return $this->hasOne('App\Models\Descriptions\IdentificationType', 'id', 'identification_type_id');
    }

    public function interests()
    {
        return $this->belongsToMany('App\Models\Descriptions\Interest', 'volunteer_interests', 'volunteer_id', 'interest_id');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\VolunteerLanguage');
    }

    public function maritalStatus()
    {
        return $this->hasOne('App\Models\Descriptions\MaritalStatus', 'id', 'marital_status_id');
    }

    public function actionHistories()
    {
        return $this->hasMany('App\Models\VolunteerActionHistory');
    }

    public function stepHistories()
    {
        return $this->hasMany('App\Models\VolunteerStepHistory');
    }

    public function units()
    {
        return $this->belongsToMany('App\Models\Unit', 'units_volunteers');
    }

    /**
     * Get all the volunteers that are assigned to a unit.
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeUnit($query, $id)
    {
        return Volunteer::whereHas('units', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

}
