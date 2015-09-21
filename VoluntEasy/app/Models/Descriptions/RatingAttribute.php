<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class RatingAttribute extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rating_attributes';

    protected $fillable = ['description'];

}
