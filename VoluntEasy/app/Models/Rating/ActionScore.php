<?php

namespace App\Models\Rating;

use App\Models\Action;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActionScore extends Model
{
    protected $table = 'action_scores';

    protected $fillable = ['action_id', 'comments', 'token', 'rated'];

    /** @return HasMany<ActionRatingScore, $this> */
    public function ratings(): HasMany
    {
        return $this->hasMany(ActionRatingScore::class, 'action_score_id', 'id');
    }

    /** @return BelongsTo<Action, $this> */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }
}
