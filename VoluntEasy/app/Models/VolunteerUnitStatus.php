<?php

namespace App\Models;

use App\Models\Descriptions\VolunteerStatus;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerUnitStatus extends Model
{
    use SoftDeletes;

    protected $table = 'volunteer_unit_status';

    protected $fillable = ['volunteer_id', 'unit_id', 'volunteer_status_id'];

    /** @return HasOne<Unit, $this> */
    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    /** @return HasOne<Volunteer, $this> */
    public function volunteer(): HasOne
    {
        return $this->hasOne(Volunteer::class, 'id', 'volunteer_id');
    }

    /** @return HasOne<VolunteerStatus, $this> */
    public function status(): HasOne
    {
        return $this->hasOne(VolunteerStatus::class, 'id', 'volunteer_status_id');
    }
}
