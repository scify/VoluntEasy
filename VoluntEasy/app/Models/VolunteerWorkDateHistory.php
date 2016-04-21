<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VolunteerWorkDateHistory extends Model {

    protected $table = 'volunteer_work_date_history';

    protected $fillable = ['volunteer_id', 'work_date_id'];

    public function workDate(){
        return $this->hasOne('App\Models\ActionTasks\SubtaskWorkDate', 'id', 'work_date_id')->withTrashed();
    }
}
