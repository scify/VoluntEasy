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

    protected $fillable = ['fromHour', 'toHour', 'subtask_work_dates_id'];


}
