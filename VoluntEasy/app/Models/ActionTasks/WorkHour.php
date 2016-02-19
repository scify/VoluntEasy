<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * The hours that the volunteers may work.
 *
 * Class Status
 * @package App\Models
 */
class WorkHour extends Model {

    protected $table = 'subtask_work_hours';

    protected $fillable = ['from_hour', 'to_hour', 'subtask_work_dates_id', 'comments'];


    public function getFromHourAttribute() {
        if ($this->attributes['from_hour'] != null)
            return \Carbon::parse($this->attributes['from_hour'])->format('H:i');
        else
            return null;
    }

    public function getToHourAttribute() {
        if ($this->attributes['to_hour'] != null)
            return \Carbon::parse($this->attributes['to_hour'])->format('H:i');
        else
            return null;
    }

}
