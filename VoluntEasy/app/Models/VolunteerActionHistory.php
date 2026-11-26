<?php namespace App\Models;



use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $type Computed: timeline entry type
 */
class VolunteerActionHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_action_history';

    protected $fillable = ['volunteer_id', 'action_id', 'user_id', 'created'];


    /** @return HasOne<\App\Models\Action, $this> */
    public function action(): HasOne {
        return $this->hasOne(\App\Models\Action::class, 'id', 'action_id')->withTrashed();
    }

    /** @return HasOne<\App\Models\User, $this> */
    public function user(): HasOne {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }


}
