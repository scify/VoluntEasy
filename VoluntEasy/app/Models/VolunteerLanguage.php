<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Model;
class VolunteerLanguage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_languages';

    protected $fillable = ['volunteer_id', 'language_id', 'language_level_id'];


    /** @return BelongsTo<\App\Models\Descriptions\Language, $this> */
    public function language(): BelongsTo {
        return $this->belongsTo(\App\Models\Descriptions\Language::class);
    }


    /** @return BelongsTo<\App\Models\Descriptions\LanguageLevel, $this> */
    public function level(): BelongsTo {
        return $this->belongsTo(\App\Models\Descriptions\LanguageLevel::class, 'language_level_id', 'id');
    }


    /** @return BelongsTo<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsTo {
        return $this->belongsTo(\App\Models\Volunteer::class);
    }

}
