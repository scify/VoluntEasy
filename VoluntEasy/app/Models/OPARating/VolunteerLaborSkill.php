<?php namespace App\Models\OPARating;

use Illuminate\Database\Eloquent\Model;

class VolunteerLaborSkill extends Model {

    protected $table = 'volunteer_opa_labor_skills';

    protected $fillable = ['comments', 'needsImprovement', 'labor_skill_id', 'opa_rating_id'];

    public function skill() {
        return $this->hasOne('App\OPARating\LaborSkill', 'id', 'labor_skill_id');
    }

}
