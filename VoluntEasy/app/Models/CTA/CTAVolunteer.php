<?php namespace App\Models\CTA;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteers that are interested in a particular action
 *
 * @package App\Models
 *
 * @property mixed $mightBe Computed: volunteers that might be this person
 */
class CTAVolunteer extends Model {

    use SoftDeletes;

    protected $table = 'cta_volunteers';

    protected $fillable = ['first_name', 'last_name', 'email', 'isVolunteer', 'public_action_id', 'comments', 'phone_number'];


    /** @return HasMany<\App\Models\CTA\CTASubtaskDate, $this> */
    public function subtaskDates(): HasMany {
        return $this->hasMany(\App\Models\CTA\CTASubtaskDate::class, 'cta_volunteers_id', 'id');
    }

    /** @return HasMany<\App\Models\CTA\CTATaskDate, $this> */
    public function taskDates(): HasMany {
        return $this->hasMany(\App\Models\CTA\CTATaskDate::class, 'cta_volunteers_id', 'id');
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'cta_volunteers_platform_volunteers', 'cta_volunteers_id', 'volunteer_id');
    }
}
