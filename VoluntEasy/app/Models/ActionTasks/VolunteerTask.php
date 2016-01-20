<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class VolunteerTask extends Model {

    protected $table = 'volunteer_tasks';

    protected $fillable = ['name', 'job_descr', 'comments', 'task_id', 'volunteer_id', 'status_id'];


    public function task() {
        return $this->belongsTo('App\Models\ActionTasks\Task');
    }

    public function volunteer() {
        return $this->belongsTo('App\Models\Volunteer');
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status');
    }

}
