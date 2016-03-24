<?php namespace App\Models\OPARating;

use Illuminate\Database\Eloquent\Model;

class VolunteerInterpersonalSkill extends Model {

    protected $table = 'volunteer_opa_interpersonal_skills';

    protected $fillable = ['description'];

    public function skill(){
        return $this->hasOne('App\OPARating\InterpersonalSkill', 'id', 'intp_skill_id');
    }

}
