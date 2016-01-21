<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Describes a task's subtasks
 *
 * Class Task
 * @package App\Models
 */
class SubTask extends Model {

    protected $table = 'subtasks';

    protected $fillable = ['description', 'name', 'status_id', 'task_id', 'priority'];

    public function status() {
        return $this->hasOne('App\Models\ActionTasks\Status', 'id', 'status_id');
    }
}
