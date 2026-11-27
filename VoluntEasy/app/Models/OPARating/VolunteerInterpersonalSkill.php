<?php

namespace App\Models\OPARating;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerInterpersonalSkill extends Model
{
    use SoftDeletes;

    protected $table = 'volunteer_opa_interpersonal_skills';

    protected $fillable = ['comments', 'needsImprovement', 'intp_skill_id', 'opa_rating_id'];

    /** @return HasOne<InterpersonalSkill, $this> */
    public function skill(): HasOne
    {
        return $this->hasOne(InterpersonalSkill::class, 'id', 'intp_skill_id');
    }
}
