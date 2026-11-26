<?php namespace App\Models\OPARating;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class VolunteerRating extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'volunteer_opa_ratings';

    protected $fillable = ['actionDescription', 'problemsOccured', 'fieldsToImprove', 'training', 'objectives', 'support', 'generalComments', 'user_id', 'volunteer_id', 'action_id', 'action_rating_id'];


    /** @return HasMany<\App\Models\OPARating\VolunteerLaborSkill, $this> */
    public function laborSkills(): HasMany {
        return $this->hasMany(\App\Models\OPARating\VolunteerLaborSkill::class, 'opa_rating_id', 'id');
    }

    /** @return HasMany<\App\Models\OPARating\VolunteerInterpersonalSkill, $this> */
    public function interpersonalSkills(): HasMany {
        return $this->hasMany(\App\Models\OPARating\VolunteerInterpersonalSkill::class, 'opa_rating_id', 'id');
    }

    /** @return BelongsTo<\App\Models\Rating\ActionRating, $this> */
    public function actionRating(): BelongsTo {
        return $this->belongsTo(\App\Models\Rating\ActionRating::class);
    }

    /** @return BelongsTo<\App\Models\Action, $this> */
    public function action(): BelongsTo {
        return $this->belongsTo(\App\Models\Action::class)->withTrashed();
    }

    /** @return BelongsTo<\App\Models\User, $this> */
    public function user(): BelongsTo {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

}
