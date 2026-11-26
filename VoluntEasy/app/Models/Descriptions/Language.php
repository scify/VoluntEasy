<?php namespace App\Models\Descriptions;


use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Model;
class Language extends Model {

    protected $table = 'languages';

    protected $fillable = ['description'];


    /** @return HasManyThrough<\App\Models\Descriptions\LanguageLevel, \App\Models\VolunteerLanguage, $this> */
    public function level(): HasManyThrough {
        return $this->hasManyThrough(\App\Models\Descriptions\LanguageLevel::class, \App\Models\VolunteerLanguage::class, 'language_level_id', 'id');
    }

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
