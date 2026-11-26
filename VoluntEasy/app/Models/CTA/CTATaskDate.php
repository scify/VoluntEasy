<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteer dates
 *
 * @package App\Models
 */
class CTATaskDate extends Model {

    use SoftDeletes;

    protected $table = 'cta_volunteers_task_dates';

    protected $fillable = ['cta_volunteers_id', 'task_shift_id'];

    /** @return HasOne<\App\Models\ActionTasks\TaskShift, $this> */
    public function date(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\TaskShift::class, 'id', 'task_shift_id');
    }
}
