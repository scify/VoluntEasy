<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerTask extends Model {

    use SoftDeletes;

    protected $table = 'volunteer_tasks';

    protected $fillable = ['name', 'job_descr', 'comments', 'task_id', 'volunteer_id', 'status_id'];

    /** @return BelongsTo<\App\Models\ActionTasks\Task, $this> */
    public function task(): BelongsTo {
        return $this->belongsTo(\App\Models\ActionTasks\Task::class);
    }

    /** @return BelongsTo<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsTo {
        return $this->belongsTo(\App\Models\Volunteer::class);
    }

    /** @return HasOne<\App\Models\ActionTasks\Status, $this> */
    public function status(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\Status::class);
    }

}
