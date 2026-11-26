<?php namespace App\Models\ActionTasks;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Describes the tasks that are needed for an action,
 * i.e  Action Bazaar needs 2 cashiers, 3 PR etc...
 *
 * Class Task
 * @package App\Models
 *
 * @property mixed $ctaSubtasks Computed
 * @property float|int $workHours Computed
 * @property mixed $unitVolunteers Computed
 */
class Task extends Model {

    use SoftDeletes;


    protected $table = 'tasks';

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $fillable = ['description', 'name', 'isComplete', 'action_id', 'priority', 'due_date', 'status_id'];


    /** @return BelongsTo<\App\Models\Action, $this> */
    public function action(): BelongsTo {
        return $this->belongsTo(\App\Models\Action::class);
    }

    /** @return HasMany<\App\Models\ActionTasks\SubTask, $this> */
    public function subtasks(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\SubTask::class);
    }

    /** @return HasMany<\App\Models\ActionTasks\SubTask, $this> */
    public function allSubtasks(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\SubTask::class)->withTrashed();
    }

    /** @return HasOne<\App\Models\ActionTasks\Status, $this> */
    public function status(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\Status::class, 'id', 'status_id');
    }

    /** @return BelongsToMany<\App\Models\User, $this> */
    public function users(): BelongsToMany {
        return $this->belongsToMany(\App\Models\User::class, 'tasks_users', 'task_id', 'user_id');
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'tasks_volunteers', 'task_id', 'volunteer_id');
    }

    public function getDueDateAttribute() {
        if ($this->attributes['due_date'] != null)
            return \Carbon::parse($this->attributes['due_date'])->format('d/m/Y');
        else
            return null;
    }

    /** @return HasMany<\App\Models\ActionTasks\TaskShift, $this> */
    public function shifts(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\TaskShift::class, 'task_id', 'id');
    }

    /** @return HasMany<\App\Models\ActionTasks\TaskShift, $this> */
    public function allShifts(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\TaskShift::class, 'task_id', 'id')->withTrashed();
    }

    /** @return HasMany<\App\Models\ActionTasks\TaskChecklist, $this> */
    public function checklist(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\TaskChecklist::class, 'task_id', 'id');
    }

}
