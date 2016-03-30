<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';

    protected $fillable = ['description'];


    public function level() {
        return $this->hasManyThrough('App\Models\Descriptions\LanguageLevel', 'App\Models\VolunteerLanguage', 'language_level_id', 'id');
    }

    public function getDescription() {
        $this->attributes['description'] = trans('database/volunteer_info.' . $this->attributes['description']);
    }

}
