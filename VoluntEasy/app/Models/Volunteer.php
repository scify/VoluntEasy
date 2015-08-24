<?php namespace App\Models;


use App\Models\Descriptions\VolunteerStatus;

class Volunteer extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'volunteers';

    protected $fillable = ['name', 'last_name', 'fathers_name', 'identification_num', 'birth_date', 'children', 'address', 'city', 'country', 'post_box', 'participation_reason', 'participation_previous', 'participation_actions', 'email', 'extra_lang', 'work_description', 'additional_skills', 'live_in_curr_country', 'comments', 'gender_id', 'education_level_id', 'comm_method', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id',
        'home_tel', 'work_tel', 'cell_tel', 'fax', 'comm_method_id', 'specialty', 'department', 'computer_usage', 'availability_time', 'interests', 'blacklisted'];


    ///////////////
    // Relations //
    ///////////////

    public function actions() {
        return $this->belongsToMany('App\Models\Action', 'actions_volunteers');
    }

    public function availabilityTimes() {
        return $this->belongsToMany('App\Models\Descriptions\AvailabilityTime', 'volunteer_availability_times', 'volunteer_id', 'availability_time_id');
    }

    public function interests() {
        return $this->belongsToMany('App\Models\Descriptions\Interest', 'volunteer_interests', 'volunteer_id', 'interest_id')->orderBy('description', 'asc');
    }

    public function availabilityFrequencies() {
        return $this->hasOne('App\Models\Descriptions\AvailabilityFrequencies', 'id', 'availability_freqs_id');
    }

    public function driverLicenceType() {
        return $this->hasOne('App\Models\Descriptions\DriverLicenceType', 'id', 'driver_license_type_id');
    }

    public function educationLevel() {
        return $this->hasOne('App\Models\Descriptions\EducationLevel', 'id', 'education_level_id');
    }

    public function identificationType() {
        return $this->hasOne('App\Models\Descriptions\IdentificationType', 'id', 'identification_type_id');
    }

    public function workStatus() {
        return $this->hasOne('App\Models\Descriptions\WorkStatus', 'id', 'work_status_id');
    }

    public function languages() {
        return $this->hasMany('App\Models\VolunteerLanguage');
    }

    public function maritalStatus() {
        return $this->hasOne('App\Models\Descriptions\MaritalStatus', 'id', 'marital_status_id');
    }

    public function gender() {
        return $this->hasOne('App\Models\Descriptions\Gender', 'id', 'gender_id');
    }

    public function commMethod() {
        return $this->hasOne('App\Models\Descriptions\CommunicationMethod', 'id', 'comm_method_id');
    }

    public function actionHistory() {
        return $this->hasMany('App\Models\VolunteerActionHistory')->orderBy('created_at', 'desc');
    }

    public function unitHistory() {
        return $this->hasMany('App\Models\VolunteerUnitHistory')->orderBy('created_at', 'desc');
    }

    public function units() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status');
    }

    public function unitsExcludes() {
        return $this->belongsToMany('App\Models\Unit', 'volunteers_units_excludes');
    }

    public function unitsPivot() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status')->withPivot('volunteer_status_id');
    }

    public function steps() {
        return $this->hasMany('App\Models\VolunteerStepStatus');
    }

    public function ratings() {
        return $this->hasOne('App\Models\Rating');
    }

    public function actionRatings() {
        return $this->hasOne('App\Models\RatingVolunteerAction');
    }

    public function getBirthDateAttribute() {
        return \Carbon::parse($this->attributes['birth_date'])->format('d/m/Y');
    }


    //////////////////
    // Query Scopes //
    //////////////////


    public function scopeBirthday($query){

    }

    /**
     * Get all the volunteers that are assigned to a unit.
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeUnit($query, $id) {
        return Volunteer::whereHas('units', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

    /*** Scopes for Volunteer Statuses ***/

    /**
     * Get pending volunteers.
     *
     * @return mixed
     */
    public function scopePending() {

        $volunteers = Volunteer::whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::pending());
        })->where('blacklisted', false)
          ->get();

        return $volunteers;
    }

    /**
     * Get available volunteers.
     * Either get all of them or only those that the user
     * is permitted to edit/assign
     *
     * @return array
     */
    public function scopeAvailable($q, $permitted = null) {

        if ($permitted == null)
            $volunteers = Volunteer::whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->whereDoesntHave('actions')->where('blacklisted', false)->get();
        else
            $volunteers = Volunteer::whereIn('id', $permitted)->whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->whereDoesntHave('actions')->where('blacklisted', false)->get();

        return $volunteers;
    }

    /**
     * Get active volunteers
     *
     * @return mixed
     */
    public function scopeActive() {

        $volunteers = Volunteer::whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::active());
        })->has('actions')->where('blacklisted', false)->with('actions')->get();

        return $volunteers;
    }

    /**
     * Get unassigned volunteers.
     * All the volunteers that are not assigned to any unit
     * or that have not completed the steps of their units.
     *
     * @return mixed
     */
    public function scopeUnassigned() {
        $volunteers = Volunteer::whereDoesntHave('units')->where('blacklisted', false)->orderBy('name', 'ASC')->get();

        return $volunteers;
    }

    /**
     * Get blacklisted volunteers
     *
     * @return mixed
     */
    public function scopeBlacklisted() {

        $volunteers = Volunteer::where('blacklisted', true)->get();

        return $volunteers;
    }


}
