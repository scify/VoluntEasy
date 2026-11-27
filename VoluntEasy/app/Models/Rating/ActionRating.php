<?php

namespace App\Models\Rating;

use App\Models\Action;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActionRating extends Model
{
    protected $table = 'action_ratings';

    protected $fillable = ['action_id', 'user_id', 'email', 'token', 'rated'];

    /** @return HasMany<VolunteerActionRating, $this> */
    public function volunteerRatings(): HasMany
    {
        return $this->hasMany(VolunteerActionRating::class, 'action_rating_id', 'id');
    }

    /** @return BelongsTo<Action, $this> */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
