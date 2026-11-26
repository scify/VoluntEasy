<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class ActionScore extends Model {
    
    protected $table = 'action_scores';

    protected $fillable = ['action_id', 'comments', 'token', 'rated'];

    /** @return HasMany<\App\Models\Rating\ActionRatingScore, $this> */
    public function ratings(): HasMany {
        return $this->hasMany(\App\Models\Rating\ActionRatingScore::class, 'action_score_id', 'id');
    }

    /** @return BelongsTo<\App\Models\Action, $this> */
    public function action(): BelongsTo {
        return $this->belongsTo(\App\Models\Action::class);
    }
}
