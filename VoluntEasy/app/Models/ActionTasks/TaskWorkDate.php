<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The dates that a volunteer may be able to work
 *
 * Class Status
 * @package App\Models
 */
class TaskWorkDate extends Model {

    use SoftDeletes;

    protected $table = 'task_work_dates';

    protected $fillable = ['from_date', 'to_date', 'task_id', 'from_hour', 'to_hour',  'volunteer_sum', 'comments'];

    protected $dates = ['from_date', 'to_date', 'deleted_at'];

    public function task() {
        return $this->belongsTo('App\Models\ActionTasks\Task', 'task_id', 'id');
    }

    public function trashedTask() {
        return $this->belongsTo('App\Models\ActionTasks\Task', 'task_id', 'id')->withTrashed();
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'volunteer_task_work_dates', 'task_work_dates_id', 'volunteer_id');
    }

    public function ctaVolunteers() {
        return $this->belongsToMany('App\Models\CTA\CTAVolunteer', 'cta_volunteers_dates', 'task_work_dates_id', 'cta_volunteers_id');
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
