<?php namespace App\Models\Descriptions;

use App\Models\Model;
class LanguageLevel extends Model {

    protected $table = 'language_levels';

    protected $fillable = ['description'];


    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }
}
