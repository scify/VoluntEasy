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

    protected $fillable = ['from_date', 'to_date', 'subtask_id', 'from_hour', 'to_hour',  'volunteer_sum', 'comments'];

    protected $dates = ['from_date', 'to_date'];

    public function subtask() {
        return $this->belongsTo('App\Models\ActionTasks\SubTask', 'subtask_id', 'id');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'volunteer_work_dates', 'subtask_work_dates_id', 'volunteer_id');
    }

    public function getFromDateAttribute() {
        if ($this->attributes['from_date'] != null)
            return \Carbon::parse($this->attributes['from_date'])->format('d/m/Y');
        else
            return null;
    }

    public function getFromHourAttribute(){
        return date('H:i', strtotime($this->attributes['from_hour']));
    }

    public function getToHourAttribute(){
        return date('H:i', strtotime($this->attributes['to_hour']));
    }
}
