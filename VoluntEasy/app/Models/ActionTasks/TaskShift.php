<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The dates that a volunteer may be able to work
 *
 * Class Status
 * @package App\Models
 *
 * @property float|int $workHours Computed
 */
class TaskShift extends Model {
    use \App\Models\Concerns\HasWorkingHours;

    use SoftDeletes;

    protected $table = 'task_shifts';

    protected $fillable = ['from_date', 'to_date', 'task_id', 'from_hour', 'to_hour',  'volunteer_sum', 'comments'];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    /** @return BelongsTo<\App\Models\ActionTasks\Task, $this> */
    public function task(): BelongsTo {
        return $this->belongsTo(\App\Models\ActionTasks\Task::class, 'task_id', 'id');
    }

    /** @return BelongsTo<\App\Models\ActionTasks\Task, $this> */
    public function trashedTask(): BelongsTo {
        return $this->belongsTo(\App\Models\ActionTasks\Task::class, 'task_id', 'id')->withTrashed();
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'volunteer_task_shifts', 'task_shift_id', 'volunteer_id');
    }

    /** @return BelongsToMany<\App\Models\CTA\CTAVolunteer, $this> */
    public function ctaVolunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\CTA\CTAVolunteer::class, 'cta_volunteers_task_dates', 'task_shifts_id', 'cta_volunteers_id');
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
