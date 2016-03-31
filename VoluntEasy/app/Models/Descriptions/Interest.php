<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class Interest extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interests';

    protected $fillable = ['description', 'category_id'];


    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

    public function category() {
        return $this->hasOne('App\Models\Descriptions\InterestCategory', 'id', 'category_id');
    }
}
