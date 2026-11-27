<?php

namespace App\Models\CTA;

use App\Models\ActionTasks\TaskShift;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteer dates
 */
class CTATaskDate extends Model
{
    use SoftDeletes;

    protected $table = 'cta_volunteers_task_dates';

    protected $fillable = ['cta_volunteers_id', 'task_shift_id'];

    /** @return HasOne<TaskShift, $this> */
    public function date(): HasOne
    {
        return $this->hasOne(TaskShift::class, 'id', 'task_shift_id');
    }
}
