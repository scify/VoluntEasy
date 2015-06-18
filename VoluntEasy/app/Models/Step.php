<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model {

    protected $table = 'steps';

    protected $fillable = ['description', 'step_order'];


    public function status(){

        dd($this->belongsToMany('App\Models\VolunteerStepStatus'));
        return $this->belongsToMany('App\Models\VolunteerStepStatus', 'volunteer_step_statuses', 'id', 'step_id');

       // return $this->hasManyThrough('App\Models\StepStatus', 'App\Models\VolunteerStepStatus', 'step_id', 'step_status_id');
    }



}
