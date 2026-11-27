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
 * Describes the tasks that are needed for an action,
 * i.e  Action Bazaar needs 2 cashiers, 3 PR etc...
 *
 * Class Task
 *
 * @property mixed $ctaSubtasks Computed
 * @property list<SubTask> $todoSubtasks Computed: for the task board
 * @property list<SubTask> $doingSubtasks Computed: for the task board
 * @property list<SubTask> $doneSubtasks Computed: for the task board
 * @property int $statusOrderId Computed: board column order
 * @property int $completedChecklistItems Computed
 * @property float|int $workHours Computed
 * @property mixed $unitVolunteers Computed
 */
class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $fillable = ['description', 'name', 'isComplete', 'action_id', 'priority', 'due_date', 'status_id'];

    /** @return BelongsTo<Action, $this> */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /** @return HasMany<SubTask, $this> */
    public function subtasks(): HasMany
    {
        return $this->hasMany(SubTask::class);
    }

    /** @return HasMany<SubTask, $this> */
    public function allSubtasks(): HasMany
    {
        return $this->hasMany(SubTask::class)->withTrashed();
    }

    /** @return HasOne<Status, $this> */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tasks_users', 'task_id', 'user_id');
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'tasks_volunteers', 'task_id', 'volunteer_id');
    }

    public function getDueDateAttribute()
    {
        if ($this->attributes['due_date'] != null) {
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        } else {
            return null;
        }
    }

    /** @return HasMany<TaskShift, $this> */
    public function shifts(): HasMany
    {
        return $this->hasMany(TaskShift::class, 'task_id', 'id');
    }

    /** @return HasMany<TaskShift, $this> */
    public function allShifts(): HasMany
    {
        return $this->hasMany(TaskShift::class, 'task_id', 'id')->withTrashed();
    }

    /** @return HasMany<TaskChecklist, $this> */
    public function checklist(): HasMany
    {
        return $this->hasMany(TaskChecklist::class, 'task_id', 'id');
    }
}
