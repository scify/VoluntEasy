<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class Rating extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    protected $fillable = ['rating', 'rating_attribute_id', 'volunteer_action_rating_id'];

    /** @return HasOne<\App\Models\Rating\RatingAttribute, $this> */
    public function attribute(): HasOne {
        return $this->hasOne(\App\Models\Rating\RatingAttribute::class, 'id', 'rating_attribute_id');
    }

}
