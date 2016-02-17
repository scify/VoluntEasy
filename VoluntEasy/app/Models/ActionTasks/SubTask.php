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

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'volunteer_subtasks', 'subtask_id', 'volunteer_id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }


}
