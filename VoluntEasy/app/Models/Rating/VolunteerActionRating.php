<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class VolunteerActionRating extends Model {
    
    protected $table = 'volunteer_action_ratings';

    protected $fillable = ['volunteer_id', 'action_rating_id', 'hours', 'minutes', 'comments', 'user_id'];

    /** @return HasMany<\App\Models\Rating\Rating, $this> */
    public function ratings(): HasMany {
        return $this->hasMany(\App\Models\Rating\Rating::class, 'volunteer_action_rating_id', 'id');
    }

    /** @return BelongsTo<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsTo {
        return $this->belongsTo(\App\Models\Volunteer::class);
    }
}
