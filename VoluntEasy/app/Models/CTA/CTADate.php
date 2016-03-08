<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteer dates
 *
 * @package App\Models
 */
class CTADate extends Model {

   use SoftDeletes;

    protected $table = 'cta_volunteers_dates';

    protected $fillable = ['cta_volunteers_id', 'subtask_work_dates_id'];

    protected $dates = ['deleted_at'];

    public function date() {
        return $this->hasOne('App\Models\ActionTasks\WorkDate', 'id', 'subtask_work_dates_id');
    }
}
