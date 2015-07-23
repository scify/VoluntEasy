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


    public function actions() {
        return $this->belongsToMany('App\Models\Action', 'actions_volunteers');
    }

    public function availabilityTimes() {
        return $this->belongsToMany('App\Models\Descriptions\AvailabilityTime', 'volunteer_availability_times', 'volunteer_id', 'availability_time_id');
    }

    public function interests() {
        return $this->belongsToMany('App\Models\Descriptions\Interests', 'volunteer_interests', 'volunteer_id', 'interest_id');
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

    // public function actionHistories() {
    //     return $this->hasMany('App\Models\VolunteerActionHistory');
    // }

    public function stepHistories() {
        return $this->hasMany('App\Models\VolunteerStepHistory');
    }

    public function units() {
        return $this->belongsToMany('App\Models\Unit', 'volunteer_unit_status');
    }

    public function steps() {
        return $this->hasMany('App\Models\VolunteerStepStatus');
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
        })->get();

        return $volunteers;

        //might be deleted
       /* $volunteers = Volunteer::has('units')->get();
        $array = [];
        foreach ($volunteers as $volunteer) {
            $id = $volunteer->id;
            $tmp = Volunteer::where('id', $id)->with(['units.steps.statuses' => function ($query) use ($id) {
                $query->where('volunteer_id', $id)->with('status');
            }])->first();

            if ($tmp != null)
                array_push($array, $tmp);
        }
        return $array;*/
    }

    /**
     * Get available volunteers.
     *
     * @return array
     */
    public function scopeAvailable() {

        $volunteers = Volunteer::whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::available());
        })->whereDoesntHave('actions')->get();

        return $volunteers;


        /*
        $tmp = Volunteer::has('units')->whereHas('steps.status', function ($query) {
            $query->where('id', 1);
        })->whereDoesntHave('actions')->get();

        $volunteers = [];
        foreach ($tmp as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $incompleteCount = 0;
                foreach ($unit->steps as $step) {
                    if ($step->statuses[0]->status->description == 'Incomplete')
                        $incompleteCount++;
                }
                if ($incompleteCount == 0)
                    array_push($volunteers, $volunteer);
            }
        }
        return $volunteers;
        */
    }

    /**
     * Get active volunteers
     *
     * @return mixed
     */
    public function scopeActive() {

       $volunteers = Volunteer::whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::active());
        })->has('actions')->get();

        return $volunteers;

        /*
        $volunteers = Volunteer::has('actions');

        return $volunteers;*/
    }

    /**
     * Get unassigned volunteers.
     * All the volunteers that are not assigned to any unit
     * or that have not completed the steps of their units.
     *
     * @return mixed
     */
    public function scopeUnassigned() {
        $volunteers = Volunteer::whereDoesntHave('units')->orderBy('name', 'ASC')->get();

        return $volunteers;
    }


}
