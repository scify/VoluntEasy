<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model {

    protected $table = 'education_levels';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
