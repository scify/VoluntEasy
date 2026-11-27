<?php

namespace App\Models\CTA;

use App\Models\Model;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteers that are interested in a particular action
 *
 *
 * @property mixed $mightBe Computed: volunteers that might be this person
 */
class CTAVolunteer extends Model
{
    use SoftDeletes;

    protected $table = 'cta_volunteers';

    protected $fillable = ['first_name', 'last_name', 'email', 'isVolunteer', 'public_action_id', 'comments', 'phone_number'];

    /** @return HasMany<CTASubtaskDate, $this> */
    public function subtaskDates(): HasMany
    {
        return $this->hasMany(CTASubtaskDate::class, 'cta_volunteers_id', 'id');
    }

    /** @return HasMany<CTATaskDate, $this> */
    public function taskDates(): HasMany
    {
        return $this->hasMany(CTATaskDate::class, 'cta_volunteers_id', 'id');
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteer(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'cta_volunteers_platform_volunteers', 'cta_volunteers_id', 'volunteer_id');
    }
}
