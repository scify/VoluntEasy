<?php

namespace App\Models\Rating;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rating extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    protected $fillable = ['rating', 'rating_attribute_id', 'volunteer_action_rating_id'];

    /** @return HasOne<RatingAttribute, $this> */
    public function attribute(): HasOne
    {
        return $this->hasOne(RatingAttribute::class, 'id', 'rating_attribute_id');
    }
}
