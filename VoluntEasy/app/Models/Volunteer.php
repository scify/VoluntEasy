<?php namespace App\Models;


class Volunteer extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteers';

    protected $fillable = ['name', 'last_name', 'fathers_name', 'identification_num', 'birth_date', 'children', 'address', 'city', 'country', 'post_box', 'participation_reason', 'participation_previous', 'participation_actions', 'email', 'extra_lang', 'work_description', 'additional_skills', 'live_in_curr_country', 'comments', 'gender_id', 'education_level_id', 'comm_method', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id',
        'home_tel', 'work_tel', 'cell_tel', 'fax', 'comm_method_id', 'specialty', 'department', 'computer_usage', 'availability_time', 'interests'];


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

    public function actionHistories() {
        return $this->hasMany('App\Models\VolunteerActionHistory');
    }

    public function stepHistories() {
        return $this->hasMany('App\Models\VolunteerStepHistory');
    }

    public function units() {
        return $this->belongsToMany('App\Models\Unit', 'units_volunteers');
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

    public function scopeSkata($query) {


        $volId = $this->id;

       //  dd($volId);

        //  return Volunteer::where('id', 5)->with('units.steps.statuses.status');

        /*
         return Volunteer::where('id', 5)->with(['units.steps' => function($query) use ($volId){
             $query->where('volunteer_id', $volId);
         }])->with('units.steps.statuses.status');
*/




        //do not delete/mess with this
        return Volunteer::with(['units.steps.statuses' => function($query) use ($volId){

            $query->where('volunteer_id', $volId)->with('status');
        }])->where('id', 5);






      // this might be correct omg
/*

        return Volunteer::where('id', 5)->whereHas('units.steps.statuses', function ($query) use ($volId) {

            $query->where('volunteer_id', $volId)->where('step_status_id', 2)->with('status');
        });
*/

        /*
                return Volunteer::whereHas('units', function ($query) use ($volId) {
                    $query->whereHas('steps', function ($query) use ($volId) {
                        //$query->with('status')->where('volunteer_id', $volId);

                        $query->with(['status' => function($query) use ($volId){
                            $query->where('volunteer_id', $volId);
                        }]);

                    });
                });
*/
        /*
                :with(array('Users' => function($query) use ($keyword){
                    $query->where('somefield', $keyword);
                }))->where('town', $keyword)->first();
                */

        /*
                $usersFilter = Addresses::with(array('Users' => function($query) use ($keyword){
                    $query->where('somefield', $keyword);
                }))->where('town', $keyword)->first();
                $myUsers = $usersFilter->users;

        */
        /*

        return Volunteer::whereHas('steps', function ($query) use ($volId) {
            $query->where('volunteer_id', $volId)->where('step_status_id', 2);
        });
*/
    }
}
