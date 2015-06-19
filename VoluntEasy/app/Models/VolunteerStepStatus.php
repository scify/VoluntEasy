<?php namespace App\Models;


class VolunteerStepStatus extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_step_status';



    public function steps()
    {
        return $this->hasMany('App\Models\Step');
    }


    public function status()
    {
        return $this->hasOne('App\Models\Descriptions\StepStatus');
    }

    public function volunteer() {
        return $this->belongsTo('App\Models\Step')->belongsTo('App\Models\Action')->belongsTo('App\Models\Volunteer');
    }


}
