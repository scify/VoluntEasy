<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;

/**
 * The dates that a volunteer may be able to work
 *
 * Class Status
 * @package App\Models
 */
class WorkDate extends Model {

    protected $table = 'subtask_work_dates';

    protected $fillable = ['from_date', 'to_date', 'subtask_id'];

    protected $dates = ['from_date', 'to_date'];

    public function hours() {
        return $this->hasMany('App\Models\ActionTasks\WorkHour', 'subtask_work_dates_id', 'id');
    }

    public function getFromDateAttribute() {
        if ($this->attributes['from_date'] != null)
            return \Carbon::parse($this->attributes['from_date'])->format('d/m/Y');
        else
            return null;
    }
}
