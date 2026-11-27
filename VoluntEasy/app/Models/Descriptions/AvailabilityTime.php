<?php

namespace App\Models\Descriptions;

use App\Models\Model;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AvailabilityTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'availability_time';

    protected $fillable = ['description'];

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteer(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_availability_times', 'availability_time_id', 'volunteer_id');
    }
}
