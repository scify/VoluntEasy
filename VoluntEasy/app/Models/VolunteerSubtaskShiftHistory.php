<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class VolunteerSubtaskShiftHistory extends Model {

    protected $table = 'volunteer_subtask_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    /** @return HasOne<\App\Models\ActionTasks\SubtaskShift, $this> */
    public function shift(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\SubtaskShift::class, 'id', 'shift_id')->withTrashed();
    }
}
