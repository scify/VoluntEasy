<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class Rating extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    protected $fillable = ['rating', 'rating_attribute_id', 'rating_volunteer_action_id'];

}
