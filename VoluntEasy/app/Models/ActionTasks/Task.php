<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;

/**
 * Describes the tasks that are needed for an action,
 * i.e  Action Bazaar needs 2 cashiers, 3 PR etc...
 *
 * Class Task
 * @package App\Models
 */
class Task extends Model {

    protected $table = 'tasks';

    protected $dates = ['due_date'];

    protected $fillable = ['description', 'name', 'isComplete', 'action_id', 'priority', 'due_date', 'status_id'];


    public function action() {
        return $this->belongsTo('App\Models\Action');
    }

    public function volunteers() {
        return $this->hasMany('App\Models\ActionTasks\VolunteerTask');
    }

    public function subtasks() {
        return $this->hasMany('App\Models\ActionTasks\SubTask');
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }


    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

}
