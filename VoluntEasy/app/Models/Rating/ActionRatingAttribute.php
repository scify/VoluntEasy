<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;


class ActionRatingAttribute extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'action_rating_attributes';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/ratings.' . $this->attributes['description']);
    }

}
