<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The fields that will be displayed in the public cta page
 *
 * Class PublicAction
 * @package App\Models
 *
 * @property mixed $tasks Computed
 */
class PublicAction extends Model {

    use SoftDeletes;

    protected $table = 'public_actions';

    protected $fillable = ['description', 'address', 'map_url', 'executive_name', 'executive_email', 'executive_phone', 'public_url', 'isActive', 'action_id'];

    /** @return BelongsTo<\App\Models\Action, $this> */
    public function action(): BelongsTo {
        return $this->belongsTo(\App\Models\Action::class, 'action_id', 'id');
    }

    /** @return HasMany<\App\Models\CTA\PublicActionSubTask, $this> */
    public function subtasks(): HasMany {
        return $this->hasMany(\App\Models\CTA\PublicActionSubTask::class, 'public_actions_id', 'id');
    }

}
