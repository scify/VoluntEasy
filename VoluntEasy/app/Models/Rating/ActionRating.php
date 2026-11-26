<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class ActionRating extends Model {
    
    protected $table = 'action_ratings';

    protected $fillable = ['action_id', 'user_id', 'email', 'token', 'rated'];

    /** @return HasMany<\App\Models\Rating\VolunteerActionRating, $this> */
    public function volunteerRatings(): HasMany {
        return $this->hasMany(\App\Models\Rating\VolunteerActionRating::class, 'action_rating_id', 'id');
    }

    /** @return BelongsTo<\App\Models\Action, $this> */
    public function action(): BelongsTo {
        return $this->belongsTo(\App\Models\Action::class);
    }

    /** @return BelongsTo<\App\Models\User, $this> */
    public function user(): BelongsTo {
        return $this->belongsTo(\App\Models\User::class);
    }
}
