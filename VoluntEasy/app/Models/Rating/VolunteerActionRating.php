<?php

namespace App\Models\Rating;

use App\Models\Model;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VolunteerActionRating extends Model
{
    protected $table = 'volunteer_action_ratings';

    protected $fillable = ['volunteer_id', 'action_rating_id', 'hours', 'minutes', 'comments', 'user_id'];

    /** @return HasMany<Rating, $this> */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'volunteer_action_rating_id', 'id');
    }

    /** @return BelongsTo<Volunteer, $this> */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
