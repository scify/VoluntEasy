<?php namespace App\Models\OPARating;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class VolunteerInterpersonalSkill extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'volunteer_opa_interpersonal_skills';

    protected $fillable = ['comments', 'needsImprovement', 'intp_skill_id', 'opa_rating_id'];

    /** @return HasOne<\App\Models\OPARating\InterpersonalSkill, $this> */
    public function skill(): HasOne {
        return $this->hasOne(\App\Models\OPARating\InterpersonalSkill::class, 'id', 'intp_skill_id');
    }

}
