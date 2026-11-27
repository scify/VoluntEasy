<?php

namespace App\Models\CTA;

use App\Models\Action;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The fields that will be displayed in the public cta page
 *
 * Class PublicAction
 *
 * @property mixed $tasks Computed
 */
class PublicAction extends Model
{
    use SoftDeletes;

    protected $table = 'public_actions';

    protected $fillable = ['description', 'address', 'map_url', 'executive_name', 'executive_email', 'executive_phone', 'public_url', 'isActive', 'action_id'];

    /** @return BelongsTo<Action, $this> */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }

    /** @return HasMany<PublicActionSubTask, $this> */
    public function subtasks(): HasMany
    {
        return $this->hasMany(PublicActionSubTask::class, 'public_actions_id', 'id');
    }
}
