<?php

namespace App\Models;

use App\Models\ActionTasks\TaskShift;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VolunteerTaskShiftHistory extends Model
{
    protected $table = 'volunteer_task_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    /** @return HasOne<TaskShift, $this> */
    public function shift(): HasOne
    {
        return $this->hasOne(TaskShift::class, 'id', 'shift_id')->withTrashed();
    }
}
