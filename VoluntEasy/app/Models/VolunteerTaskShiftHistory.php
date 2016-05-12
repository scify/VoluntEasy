<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VolunteerTaskShiftHistory extends Model {

    protected $table = 'volunteer_task_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    public function shift(){
        return $this->hasOne('App\Models\ActionTasks\TaskShift', 'id', 'shift_id')->withTrashed();
    }
}
