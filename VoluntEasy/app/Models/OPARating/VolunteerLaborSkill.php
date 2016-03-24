<?php namespace App\Models\OPARating;

use Illuminate\Database\Eloquent\Model;

class VolunteerLaborSkill extends Model {

    protected $table = 'volunteer_opa_labor_skills';

    protected $fillable = ['description'];

    public function skill(){
        return $this->hasOne('App\OPARating\LaborSkill', 'id', 'labor_skill_id');
    }

}
