<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;


class Rating extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    protected $fillable = ['rating', 'rating_attribute_id', 'volunteer_action_rating_id'];


    public function attribute()
    {
        return $this->hasOne('App\Models\Rating\RatingAttribute', 'id', 'rating_attribute_id');
    }

}
