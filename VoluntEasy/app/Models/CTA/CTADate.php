<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

/**
 * The volunteer dates
 *
 * @package App\Models
 */
class CTADate extends Model {

    protected $table = 'cta_volunteers_dates';

    protected $fillable = ['cta_volunteers_id', 'subtask_work_dates_id'];


    public function date() {
        return $this->hasOne('App\Models\ActionTasks\WorkDate', 'id', 'subtask_work_dates_id');
    }
}
