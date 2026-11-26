<?php namespace App\Models\OPARating;

use App\Models\Model;
class InterpersonalSkill extends Model {

    protected $table = 'opa_interpersonal_skills';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/ratings.' . $this->attributes['description']);
    }
}
