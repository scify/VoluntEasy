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


    public function step_statuses()
    {
        return $this->hasMany('App\Models\Descriptions\StepStatus');
    }


}
