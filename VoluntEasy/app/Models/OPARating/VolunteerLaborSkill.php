<?php

namespace App\Models\OPARating;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerLaborSkill extends Model
{
    use SoftDeletes;

    protected $table = 'volunteer_opa_labor_skills';

    protected $fillable = ['comments', 'needsImprovement', 'labor_skill_id', 'opa_rating_id'];

    /** @return HasOne<LaborSkill, $this> */
    public function skill(): HasOne
    {
        return $this->hasOne(LaborSkill::class, 'id', 'labor_skill_id');
    }
}
