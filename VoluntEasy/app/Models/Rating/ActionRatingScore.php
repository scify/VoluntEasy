<?php namespace App\Models\Rating;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property string $description Computed
 */
class ActionRatingScore extends Model {
    
    protected $table = 'action_rating_scores';

    protected $fillable = ['score', 'attribute_id', 'action_score_id'];


    /** @return HasOne<\App\Models\Rating\ActionRatingAttribute, $this> */
    public function attribute(): HasOne {
        return $this->hasOne(\App\Models\Rating\ActionRatingAttribute::class, 'id', 'attribute_id');
    }
}
