<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class InterestCategory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interest_categories';

    protected $fillable = ['description'];


    public function interests() {
        return $this->hasMany('App\Models\Descriptions\Interest', 'category_id', 'id')->orderBy('description', 'asc');
    }

}
