<?php

namespace App\Models\ActionTasks;

use App\Models\Action;
use App\Models\Model;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Describes a task's subtasks
 *
 * Class Task
 *
 * @property float|int $workHours Computed
 * @property int $volunteerSum Computed
 * @property int $ctaVolunteersCount Computed
 * @property int $completedChecklistItems Computed
 * @property mixed $unitVolunteers Computed
 */
class SubTask extends Model
{
    use SoftDeletes;

    protected $table = 'subtasks';

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $fillable = ['description', 'name', 'status_id', 'task_id', 'action_id', 'priority', 'due_date'];

    /** @return BelongsTo<Task, $this> */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    /** @return BelongsTo<Task, $this> */
    public function trashedTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id')->withTrashed();
    }

    /** @return HasOne<Status, $this> */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /** @return HasOne<Action, $this> */
    public function action(): HasOne
    {
        return $this->hasOne(Action::class, 'id', 'action_id');
    }

    /** @return HasMany<SubtaskShift, $this> */
    public function shifts(): HasMany
    {
        return $this->hasMany(SubtaskShift::class, 'subtask_id', 'id');
    }

    /** @return HasMany<SubtaskShift, $this> */
    public function allShifts(): HasMany
    {
        return $this->hasMany(SubtaskShift::class, 'subtask_id', 'id')->withTrashed();
    }

    /** @return HasMany<SubtaskChecklist, $this> */
    public function checklist(): HasMany
    {
        return $this->hasMany(SubtaskChecklist::class, 'subtask_id', 'id');
    }

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subtasks_users', 'subtask_id', 'user_id');
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'subtasks_volunteers', 'subtask_id', 'volunteer_id');
    }

    public function getDueDateAttribute()
    {
        if ($this->attributes['due_date'] != null) {
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        } else {
            return null;
        }
    }
}
