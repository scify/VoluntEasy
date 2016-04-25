<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Describes a task's subtasks
 *
 * Class Task
 * @package App\Models
 */
class SubTask extends Model {

    use SoftDeletes;

    protected $table = 'subtasks';

    protected $dates = ['due_date', 'deleted_at'];

    protected $fillable = ['description', 'name', 'status_id', 'task_id', 'action_id', 'priority', 'due_date'];


    public function task() {
        return $this->belongsTo('App\Models\ActionTasks\Task', 'task_id', 'id');
    }

    public function trashedTask() {
        return $this->belongsTo('App\Models\ActionTasks\Task', 'task_id', 'id')->withTrashed();
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }

    public function action() {
        return $this->hasOne('App\Models\Action', 'id', 'action_id');
    }

    public function shifts(){
        return $this->hasMany('App\Models\ActionTasks\SubtaskShift', 'subtask_id', 'id');
    }

    public function allShifts(){
        return $this->hasMany('App\Models\ActionTasks\SubtaskShift', 'subtask_id', 'id')->withTrashed();
    }

    public function checklist(){
        return $this->hasMany('App\Models\ActionTasks\ChecklistItem', 'subtask_id', 'id');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User', 'subtasks_users', 'subtask_id', 'user_id');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'subtasks_volunteers', 'subtask_id', 'volunteer_id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

}
