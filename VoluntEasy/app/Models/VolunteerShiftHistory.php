<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VolunteerSubtaskShiftHistory extends Model {

    protected $table = 'volunteer_subtask_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    public function shift(){
        return $this->hasOne('App\Models\ActionTasks\SubtaskShift', 'id', 'shift_id')->withTrashed();
    }
}
