<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class VolunteerTask extends Model {

    protected $table = 'volunteer_tasks';

    protected $fillable = ['name', 'task_date', 'task_time', 'comments', 'working_hours', 'action_id', 'task_id', 'volunteer_id', 'status_id'];


    public function task() {
        return $this->belongsTo('App\Models\ActionTasks\Task');
    }

    public function volunteer() {
        return $this->belongsTo('App\Models\Volunteer');
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status');
    }

    public function action() {
        return $this->belongsTo('App\Models\Action');
    }
}
