<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Model;
class AvailabilityTime extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'availability_time';

    protected $fillable = ['description'];

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'volunteer_availability_times', 'availability_time_id', 'volunteer_id');
    }
}
