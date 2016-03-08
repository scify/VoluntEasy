<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VolunteerTask extends Model {

    use SoftDeletes;

    protected $table = 'volunteer_tasks';

    protected $fillable = ['name', 'job_descr', 'comments', 'task_id', 'volunteer_id', 'status_id'];

    protected $dates = ['deleted_at'];

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
