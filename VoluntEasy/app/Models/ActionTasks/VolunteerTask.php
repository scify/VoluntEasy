<?php

namespace App\Models\ActionTasks;

use App\Models\Model;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerTask extends Model
{
    use SoftDeletes;

    protected $table = 'volunteer_tasks';

    protected $fillable = ['name', 'job_descr', 'comments', 'task_id', 'volunteer_id', 'status_id'];

    /** @return BelongsTo<Task, $this> */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /** @return BelongsTo<Volunteer, $this> */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    /** @return HasOne<Status, $this> */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }
}
