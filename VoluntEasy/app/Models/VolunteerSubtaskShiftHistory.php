<?php

namespace App\Models;

use App\Models\ActionTasks\SubtaskShift;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VolunteerSubtaskShiftHistory extends Model
{
    protected $table = 'volunteer_subtask_shift_history';

    protected $fillable = ['volunteer_id', 'shift_id'];

    /** @return HasOne<SubtaskShift, $this> */
    public function shift(): HasOne
    {
        return $this->hasOne(SubtaskShift::class, 'id', 'shift_id')->withTrashed();
    }
}
