<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class VolunteerUnitStatus extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'volunteer_unit_status';

    protected $fillable = ['volunteer_id', 'unit_id', 'volunteer_status_id'];

    /** @return HasOne<\App\Models\Unit, $this> */
    public function unit(): HasOne {
        return $this->hasOne(\App\Models\Unit::class, 'id', 'unit_id');
    }

    /** @return HasOne<\App\Models\Volunteer, $this> */
    public function volunteer(): HasOne {
        return $this->hasOne(\App\Models\Volunteer::class, 'id', 'volunteer_id');
    }

    /** @return HasOne<\App\Models\Descriptions\VolunteerStatus, $this> */
    public function status(): HasOne {
        return $this->hasOne(\App\Models\Descriptions\VolunteerStatus::class, 'id', 'volunteer_status_id');
    }

}
