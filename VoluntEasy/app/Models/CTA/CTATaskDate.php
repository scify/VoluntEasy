<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
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

    protected $dates = ['deleted_at'];

    public function date() {
        return $this->hasOne('App\Models\ActionTasks\TaskShift', 'id', 'task_shift_id');
    }
}
