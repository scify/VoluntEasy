<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * The status of an action's task,
 * i.e. complete, incomplete, etc.
 *
 * Class Status
 * @package App\Models
 */
class Status extends Model {

    protected $table = 'task_statuses';

    protected $fillable = ['name'];


    public function scopeTodo($query){
        return $query->where('name', 'To Do')->first()->id;
    }

    public function scopeDoing($query){
        return $query->where('name', 'Doing')->first()->id;
    }

    public function scopeDone($query){
        return $query->where('name', 'Done')->first()->id;
    }

}