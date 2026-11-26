<?php namespace App\Models\Descriptions;

use App\Models\Model;
class Gender extends Model {

    protected $table = 'genders';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
