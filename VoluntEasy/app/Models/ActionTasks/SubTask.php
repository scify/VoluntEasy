<?php namespace App\Models\ActionTasks;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Describes a task's subtasks
 *
 * Class Task
 * @package App\Models
 *
 * @property float|int $workHours Computed
 * @property mixed $unitVolunteers Computed
 */
class SubTask extends Model {

    use SoftDeletes;

    protected $table = 'subtasks';

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $fillable = ['description', 'name', 'status_id', 'task_id', 'action_id', 'priority', 'due_date'];


    /** @return BelongsTo<\App\Models\ActionTasks\Task, $this> */
    public function task(): BelongsTo {
        return $this->belongsTo(\App\Models\ActionTasks\Task::class, 'task_id', 'id');
    }

    /** @return BelongsTo<\App\Models\ActionTasks\Task, $this> */
    public function trashedTask(): BelongsTo {
        return $this->belongsTo(\App\Models\ActionTasks\Task::class, 'task_id', 'id')->withTrashed();
    }

    /** @return HasOne<\App\Models\ActionTasks\Status, $this> */
    public function status(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\Status::class, 'id', 'status_id');
    }

    /** @return HasOne<\App\Models\Action, $this> */
    public function action(): HasOne {
        return $this->hasOne(\App\Models\Action::class, 'id', 'action_id');
    }

    /** @return HasMany<\App\Models\ActionTasks\SubtaskShift, $this> */
    public function shifts(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\SubtaskShift::class, 'subtask_id', 'id');
    }

    /** @return HasMany<\App\Models\ActionTasks\SubtaskShift, $this> */
    public function allShifts(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\SubtaskShift::class, 'subtask_id', 'id')->withTrashed();
    }

    /** @return HasMany<\App\Models\ActionTasks\SubtaskChecklist, $this> */
    public function checklist(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\SubtaskChecklist::class, 'subtask_id', 'id');
    }

    /** @return BelongsToMany<\App\Models\User, $this> */
    public function users(): BelongsToMany {
        return $this->belongsToMany(\App\Models\User::class, 'subtasks_users', 'subtask_id', 'user_id');
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'subtasks_volunteers', 'subtask_id', 'volunteer_id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

}
