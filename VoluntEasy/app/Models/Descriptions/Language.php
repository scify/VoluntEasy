<?php

namespace App\Models\Descriptions;

use App\Models\Model;
use App\Models\VolunteerLanguage;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = ['description'];

    /** @return HasManyThrough<LanguageLevel, VolunteerLanguage, $this> */
    public function level(): HasManyThrough
    {
        return $this->hasManyThrough(LanguageLevel::class, VolunteerLanguage::class, 'language_level_id', 'id');
    }

    public function getDescriptionAttribute()
    {
        return trans('database/db_tables.'.$this->attributes['description']);
    }
}
