<?php namespace App\Models\OPARating;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class VolunteerLaborSkill extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'volunteer_opa_labor_skills';

    protected $fillable = ['comments', 'needsImprovement', 'labor_skill_id', 'opa_rating_id'];

    /** @return HasOne<\App\Models\OPARating\LaborSkill, $this> */
    public function skill(): HasOne {
        return $this->hasOne(\App\Models\OPARating\LaborSkill::class, 'id', 'labor_skill_id');
    }

}
