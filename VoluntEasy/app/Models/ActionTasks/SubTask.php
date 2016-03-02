<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;

/**
 * Describes a task's subtasks
 *
 * Class Task
 * @package App\Models
 */
class SubTask extends Model {

    protected $table = 'subtasks';

    protected $dates = ['due_date'];

    protected $fillable = ['description', 'name', 'status_id', 'task_id', 'action_id', 'priority', 'due_date'];


    public function task() {
        return $this->belongsTo('App\Models\ActionTasks\Task', 'task_id', 'id');
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }

    public function action() {
        return $this->hasOne('App\Models\Action', 'id', 'action_id');
    }

    public function workDates(){
        return $this->hasMany('App\Models\ActionTasks\WorkDate', 'subtask_id', 'id');
    }

    public function checklist(){
        return $this->hasMany('App\Models\ActionTasks\ChecklistItem', 'subtask_id', 'id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

}
