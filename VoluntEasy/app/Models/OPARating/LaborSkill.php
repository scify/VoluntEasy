<?php namespace App\Models\OPARating;

use App\Models\Model;
class LaborSkill extends Model {

    protected $table = 'opa_labor_skills';

    protected $fillable = ['description'];


    public function getDescriptionAttribute() {
        return trans('database/ratings.' . $this->attributes['description']);
    }
}
