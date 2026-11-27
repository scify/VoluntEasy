<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $type Computed: timeline entry type
 */
class VolunteerActionHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_action_history';

    protected $fillable = ['volunteer_id', 'action_id', 'user_id', 'created'];

    /** @return HasOne<Action, $this> */
    public function action(): HasOne
    {
        return $this->hasOne(Action::class, 'id', 'action_id')->withTrashed();
    }

    /** @return HasOne<User, $this> */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
