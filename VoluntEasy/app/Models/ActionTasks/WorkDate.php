<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * The dates that a volunteer may be able to work
 *
 * Class Status
 * @package App\Models
 */
class WorkDate extends Model {

    protected $table = 'subtask_work_dates';

    protected $fillable = ['fromDate', 'toDate', 'subtask_id'];


    public function hours(){
        $this->hasMany('App\Models\ActionTasks\WorkHours', 'subtask_work_dates_id', 'id');
    }

}
