<?php

namespace App\Models\Rating;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $description Computed
 */
class ActionRatingScore extends Model
{
    protected $table = 'action_rating_scores';

    protected $fillable = ['score', 'attribute_id', 'action_score_id'];

    /** @return HasOne<ActionRatingAttribute, $this> */
    public function attribute(): HasOne
    {
        return $this->hasOne(ActionRatingAttribute::class, 'id', 'attribute_id');
    }
}
