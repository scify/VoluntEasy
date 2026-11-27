<?php

namespace App\Models;

use App\Models\Descriptions\StepStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Step extends Model
{
    use SoftDeletes;

    protected $table = 'steps';

    protected $fillable = ['description', 'step_order', 'type'];

    public function getDescriptionAttribute()
    {
        return trans('database/db_tables.'.$this->attributes['description']);
    }

    /** @return HasManyThrough<StepStatus, VolunteerStepStatus, $this> */
    public function status(): HasManyThrough
    {
        return $this->hasManyThrough(StepStatus::class, VolunteerStepStatus::class, 'step_status_id', 'id');
    }

    /** @return HasMany<VolunteerStepStatus, $this> */
    public function statuses(): HasMany
    {
        return $this->hasMany(VolunteerStepStatus::class, 'step_id', 'id');
    }
}
