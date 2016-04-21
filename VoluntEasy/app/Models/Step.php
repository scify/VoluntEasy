<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'steps';

    protected $fillable = ['description', 'step_order', 'type'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }


    public function status(){
        return $this->hasManyThrough('App\Models\Descriptions\StepStatus', 'App\Models\VolunteerStepStatus', 'step_status_id', 'id');
    }


    public function statuses(){
        return $this->hasMany('App\Models\VolunteerStepStatus', 'step_id', 'id');
    }


}
