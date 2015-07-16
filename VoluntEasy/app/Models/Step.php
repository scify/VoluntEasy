<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model {

    protected $table = 'steps';

    protected $fillable = ['description', 'step_order'];


    public function status(){
        return $this->hasManyThrough('App\Models\Descriptions\StepStatus', 'App\Models\VolunteerStepStatus', 'step_status_id', 'id');
    }

}
