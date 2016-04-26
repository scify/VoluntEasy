<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Describes the tasks that are needed for an action,
 * i.e  Action Bazaar needs 2 cashiers, 3 PR etc...
 *
 * Class Task
 * @package App\Models
 */
class Task extends Model {

    use SoftDeletes;


    protected $table = 'tasks';

    protected $dates = ['due_date', 'deleted_at'];

    protected $fillable = ['description', 'name', 'isComplete', 'action_id', 'priority', 'due_date', 'status_id'];


    public function action() {
        return $this->belongsTo('App\Models\Action');
    }

    /*
        public function volunteers() {
            return $this->hasMany('App\Models\ActionTasks\VolunteerTask');
        }*/

    public function subtasks() {
        return $this->hasMany('App\Models\ActionTasks\SubTask');
    }

    public function allSubtasks() {
        return $this->hasMany('App\Models\ActionTasks\SubTask')->withTrashed();
    }

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User', 'tasks_users', 'task_id', 'user_id');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'tasks_volunteers', 'task_id', 'volunteer_id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

    public function shifts(){
        return $this->hasMany('App\Models\ActionTasks\TaskShift', 'task_id', 'id');
    }

    public function allShifts(){
        return $this->hasMany('App\Models\ActionTasks\TaskShift', 'task_id', 'id')->withTrashed();
    }

    public function checklist(){
        return $this->hasMany('App\Models\ActionTasks\TaskChecklist', 'task_id', 'id');
    }

}
