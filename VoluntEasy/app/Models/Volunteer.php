<?php namespace App\Models;


use App\Models\CTA\CTAVolunteer;
use App\Models\Descriptions\VolunteerStatus;

class Volunteer extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];

    protected $table = 'volunteers';

    protected $fillable = ['name', 'last_name', 'fathers_name', 'identification_num', 'birth_date', 'children', 'address', 'city', 'country', 'post_box', 'participation_reason', 'participation_previous', 'participation_actions', 'email', 'extra_lang', 'work_description', 'additional_skills', 'live_in_curr_country', 'comments', 'gender_id', 'education_level_id', 'comm_method', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id',
        'home_tel', 'work_tel', 'cell_tel', 'fax', 'comm_method_id', 'specialty', 'department', 'computer_usage', 'availability_time', 'interests', 'blacklisted', 'not_available', 'how_you_learned_id', 'how_you_learned2_id', 'computer_usage_comments', 'afm', 'contract_date', 'image_name'];


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

    public function volunteeringDepartments() {
        return $this->belongsToMany('App\Models\Descriptions\VolunteeringDepartment', 'volunteer_volunteering_departments', 'volunteer_id', 'department_id');
    }

    public function availabilityFrequencies() {
        return $this->hasOne('App\Models\Descriptions\AvailabilityFrequencies', 'id', 'availability_freqs_id');
    }

    public function availabilityDays() {
        return $this->hasMany('App\Models\Descriptions\AvailabilityDay');
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

    public function howYouLearned() {
        return $this->hasOne('App\Models\Descriptions\HowYouLearned', 'id', 'how_you_learned_id');
    }

    public function howYouLearned2() {
        return $this->hasOne('App\Models\Descriptions\HowYouLearned2', 'id', 'how_you_learned2_id');
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

    public function actionHistoryNewest() {
        return $this->hasOne('App\Models\VolunteerActionHistory')->orderBy('created_at', 'desc');
    }

    public function unitHistory() {
        return $this->hasMany('App\Models\VolunteerUnitHistory')->orderBy('created_at', 'desc');
    }

    public function taskShiftHistory() {
        return $this->hasMany('App\Models\VolunteerTaskShiftHistory')->orderBy('created_at', 'desc');
    }

    public function subtaskShiftHistory() {
        return $this->hasMany('App\Models\VolunteerSubtaskShiftHistory')->orderBy('created_at', 'desc');
    }

    public function units() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status')->whereNull('volunteer_unit_status.deleted_at');
    }

    public function unitsExcludes() {
        return $this->belongsToMany('App\Models\Unit', 'volunteers_units_excludes');
    }

    public function unitsPivot() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status')->withPivot('volunteer_status_id');
    }

    public function unitsStatus() {
        return $this->hasMany('App\Models\VolunteerUnitStatus')->withTrashed();
    }

    public function steps() {
        return $this->hasMany('App\Models\VolunteerStepStatus');
    }

    public function files() {
        return $this->hasMany('App\Models\File');
    }

    public function taskShifts() {
        return $this->belongsToMany('App\Models\ActionTasks\TaskShift', 'volunteer_task_shifts', 'volunteer_id', 'task_shift_id');
    }

    public function subtaskShifts() {
        return $this->belongsToMany('App\Models\ActionTasks\SubtaskShift', 'volunteer_subtask_shifts', 'volunteer_id', 'subtask_shifts_id');
    }

    public function extras() {
        return $this->hasOne('App\Models\VolunteerExtras', 'volunteer_id', 'id');
    }

    public function ctaVolunteers() {
        return $this->belongsToMany('App\Models\CTA\CTAVolunteer', 'cta_volunteers_platform_volunteers', 'volunteer_id', 'cta_volunteers_id');
    }

    public function opaRatings() {
        return $this->hasMany('App\Models\OPARating\VolunteerRating')->withTrashed();
    }

    /*
    public function ratings() {
        return $this->hasOne('App\Models\Rating');
    }
    */

    /*public function actionRatings() {
        return $this->hasOne('App\Models\RatingVolunteerAction');
    }*/

    public function statusDuration() {
        return $this->hasMany('App\Models\Descriptions\VolunteerStatusDuration');
    }

    public function getBirthDateAttribute() {
        if ($this->attributes['birth_date'] != null && $this->attributes['birth_date'] != '0000-00-00')
            return \Carbon::parse($this->attributes['birth_date'])->format('d/m/Y');
        else return null;
    }

    public function getContractDateAttribute() {
        if ($this->attributes['contract_date'] != null)
            return \Carbon::parse($this->attributes['contract_date'])->format('d/m/Y');
        else return null;
    }

    public function getFullNameAttribute() {
        return $this->name . " " . $this->last_name;
    }


    //////////////////
    // Query Scopes //
    //////////////////

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
    public function scopePending($query) {

        $query->whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::pending());
        })->where('blacklisted', false)->where('not_available', false)
            ->get();
    }

    /**
     * Get available volunteers.
     * Either get all of them or only those that the user
     * is permitted to edit/assign
     *
     * @return array
     */
    public function scopeAvailable($query, $permitted = null) {

        if ($permitted == null)
            $query->whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->where('blacklisted', false)->where('not_available', false)->get();
        else
            $query->whereIn('id', $permitted)->whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->where('blacklisted', false)->where('not_available', false)->get();
    }

    /**
     * Get active volunteers
     *
     * @return mixed
     */
    public function scopeActive($query) {

        $query->whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::active());
        })->has('actions')->where('blacklisted', false)->where('not_available', false)->with('actions')->get();

    }

    /**
     * Get unassigned volunteers.
     * All the volunteers that are not assigned to any unit
     * or that have not completed the steps of their units.
     *
     * @return mixed
     */
    public function scopeUnassigned($query) {
        $query->whereDoesntHave('units')->where('blacklisted', false)->where('not_available', false)->orderBy('name', 'ASC')->get();
    }

    public function scopeNotAvailable($query) {

        $query->where('not_available', true)->get();
    }

    /**
     * Get blacklisted volunteers
     *
     * @return mixed
     */
    public function scopeBlacklisted($query) {

        $query->where('blacklisted', true);
    }

    /**
     * Check if Volunteer is interested in any action
     * \     */
    public function interestedIn() {

        $ctaVolunteers = CTAVolunteer::where('email', $this->attributes['email'])->with('dates.date.subtask.task')->get();
        return $ctaVolunteers;
    }

    /**
     * Find the volunteers whose contract was signed a year ago
     *
     * @return mixed
     */
    public function scopeExpiredContract() {
        $today = \Carbon::today();
        return $this->where('contract_date', '=', $today->subYear());
    }

    /**
     * Find the volunteers whose contract expires in 6 months
     *
     * @return mixed
     */
    public function scopeToExpireContract() {
        $today = \Carbon::today();
        return $this->where('contract_date', '=', $today->subMonths(6));
    }

}
