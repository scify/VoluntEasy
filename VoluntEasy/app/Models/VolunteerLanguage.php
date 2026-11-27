<?php

namespace App\Models;

use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerLanguage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_languages';

    protected $fillable = ['volunteer_id', 'language_id', 'language_level_id'];

    /** @return BelongsTo<Language, $this> */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /** @return BelongsTo<LanguageLevel, $this> */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LanguageLevel::class, 'language_level_id', 'id');
    }

    /** @return BelongsTo<Volunteer, $this> */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
