<?php

namespace App\Models;

use App\Models\Descriptions\StepStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerStepStatus extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_step_status';

    protected $fillable = ['step_id', 'step_status_id', 'assignTo'];

    /** @return BelongsTo<Step, $this> */
    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

    /** @return BelongsTo<StepStatus, $this> */
    public function status(): BelongsTo
    {
        return $this->belongsTo(StepStatus::class, 'step_status_id', 'id');
    }

    /** @return BelongsTo<Volunteer, $this> */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
