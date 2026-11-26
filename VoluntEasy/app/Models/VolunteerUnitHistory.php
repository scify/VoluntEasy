<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $type Computed: timeline entry type
 */
class VolunteerUnitHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_unit_history';

    protected $fillable = ['volunteer_id', 'unit_id', 'user_id', 'created'];


    /** @return HasOne<\App\Models\Unit, $this> */
    public function unit(): HasOne {
        return $this->hasOne(\App\Models\Unit::class, 'id', 'unit_id');
    }


    /** @return HasOne<\App\Models\User, $this> */
    public function user(): HasOne {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

}
