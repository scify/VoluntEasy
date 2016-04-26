<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The volunteers that are interested in a particular action
 *
 * @package App\Models
 */
class CTAVolunteer extends Model {

    use SoftDeletes;

    protected $table = 'cta_volunteers';

    protected $fillable = ['first_name', 'last_name', 'email', 'isVolunteer', 'public_action_id', 'comments', 'phone_number'];

   protected $dates = ['deleted_at'];

    public function subtaskDates() {
        return $this->hasMany('App\Models\CTA\CTASubtaskDate', 'cta_volunteers_id', 'id');
    }

    public function taskDates() {
        return $this->hasMany('App\Models\CTA\CTATaskDate', 'cta_volunteers_id', 'id');
    }

    public function volunteer() {
        return $this->belongsToMany('App\Models\Volunteer', 'cta_volunteers_platform_volunteers', 'cta_volunteers_id', 'volunteer_id');
    }
}
