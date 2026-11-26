<?php namespace App\Models\Descriptions;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $type Computed: timeline entry type
 */
class VolunteerStatusDuration extends Model {

    use SoftDeletes;

    protected $table = 'volunteer_status_duration';

    protected $fillable = ['from_date', 'to_date', 'volunteer_id', 'status_id', 'comments'];


    /** @return HasOne<\App\Models\Descriptions\VolunteerStatus, $this> */
    public function status(): HasOne {
        return $this->hasOne(\App\Models\Descriptions\VolunteerStatus::class, 'id', 'status_id');
    }

    public function getFromDateAttribute() {
        return \Carbon::parse($this->attributes['from_date'])->format('d/m/Y');
    }

    public function getToDateAttribute() {
        return \Carbon::parse($this->attributes['to_date'])->format('d/m/Y');
    }

}
