<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

/**
 * The volunteers that are interested in a particular action
 *
 * @package App\Models
 */
class CTAVolunteer extends Model {

    protected $table = 'cta_volunteers';

    protected $fillable = ['first_name', 'last_name', 'email', 'isAssigned', 'isVolunteer', 'public_action_id'];

    public function dates() {
        return $this->hasMany('App\Models\CTA\CTADate', 'cta_volunteers_id', 'id');
    }
}
