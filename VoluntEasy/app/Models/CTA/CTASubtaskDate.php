<?php

namespace App\Models\CTA;

use App\Models\ActionTasks\SubtaskShift;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteer dates
 */
class CTASubtaskDate extends Model
{
    use SoftDeletes;

    protected $table = 'cta_volunteers_subtask_dates';

    protected $fillable = ['cta_volunteers_id', 'subtask_shift_id'];

    /** @return HasOne<SubtaskShift, $this> */
    public function date(): HasOne
    {
        return $this->hasOne(SubtaskShift::class, 'id', 'subtask_shift_id');
    }
}
