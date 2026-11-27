<?php

namespace App\Models\OPARating;

use App\Models\Action;
use App\Models\Model;
use App\Models\Rating\ActionRating;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerRating extends Model
{
    use SoftDeletes;

    protected $table = 'volunteer_opa_ratings';

    protected $fillable = ['actionDescription', 'problemsOccured', 'fieldsToImprove', 'training', 'objectives', 'support', 'generalComments', 'user_id', 'volunteer_id', 'action_id', 'action_rating_id'];

    /** @return HasMany<VolunteerLaborSkill, $this> */
    public function laborSkills(): HasMany
    {
        return $this->hasMany(VolunteerLaborSkill::class, 'opa_rating_id', 'id');
    }

    /** @return HasMany<VolunteerInterpersonalSkill, $this> */
    public function interpersonalSkills(): HasMany
    {
        return $this->hasMany(VolunteerInterpersonalSkill::class, 'opa_rating_id', 'id');
    }

    /** @return BelongsTo<ActionRating, $this> */
    public function actionRating(): BelongsTo
    {
        return $this->belongsTo(ActionRating::class);
    }

    /** @return BelongsTo<Action, $this> */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class)->withTrashed();
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
