<?php

namespace App\Models\ActionTasks;

use App\Models\Concerns\HasWorkingHours;
use App\Models\CTA\CTAVolunteer;
use App\Models\Model;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The dates that a volunteer may be able to work
 *
 * Class Status
 *
 * @property float|int $workHours Computed
 */
class SubtaskShift extends Model
{
    use HasWorkingHours;
    use SoftDeletes;

    protected $table = 'subtask_shifts';

    protected $fillable = ['from_date', 'to_date', 'subtask_id', 'from_hour', 'to_hour',  'volunteer_sum', 'comments'];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    /** @return BelongsTo<SubTask, $this> */
    public function subtask(): BelongsTo
    {
        return $this->belongsTo(SubTask::class, 'subtask_id', 'id');
    }

    /** @return BelongsTo<SubTask, $this> */
    public function trashedSubtask(): BelongsTo
    {
        return $this->belongsTo(SubTask::class, 'subtask_id', 'id')->withTrashed();
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_subtask_shifts', 'subtask_shifts_id', 'volunteer_id');
    }

    /** @return BelongsToMany<CTAVolunteer, $this> */
    public function ctaVolunteers(): BelongsToMany
    {
        return $this->belongsToMany(CTAVolunteer::class, 'cta_volunteers_subtask_dates', 'subtask_shifts_id', 'cta_volunteers_id');
    }

    public function getFromDateAttribute()
    {
        if ($this->attributes['from_date'] != null) {
            return \Carbon::parse($this->attributes['from_date'])->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function getFromHourAttribute()
    {
        return date('H:i', strtotime($this->attributes['from_hour']));
    }

    public function getToHourAttribute()
    {
        return date('H:i', strtotime($this->attributes['to_hour']));
    }
}
