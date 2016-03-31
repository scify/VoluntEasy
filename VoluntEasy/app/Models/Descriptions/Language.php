<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';

    protected $fillable = ['description'];


    public function level() {
        return $this->hasManyThrough('App\Models\Descriptions\LanguageLevel', 'App\Models\VolunteerLanguage', 'language_level_id', 'id');
    }

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
