<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class VolunteerTaskShiftHistory extends Model {

    protected $table = 'volunteer_task_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    /** @return HasOne<\App\Models\ActionTasks\TaskShift, $this> */
    public function shift(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\TaskShift::class, 'id', 'shift_id')->withTrashed();
    }
}
