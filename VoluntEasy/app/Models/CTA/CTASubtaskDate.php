<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteer dates
 *
 * @package App\Models
 */
class CTASubtaskDate extends Model {

    use SoftDeletes;

    protected $table = 'cta_volunteers_subtask_dates';

    protected $fillable = ['cta_volunteers_id', 'subtask_shift_id'];

    /** @return HasOne<\App\Models\ActionTasks\SubtaskShift, $this> */
    public function date(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\SubtaskShift::class, 'id', 'subtask_shift_id');
    }
}
