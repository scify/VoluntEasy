<?php namespace App\Models\Descriptions;

use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property int $count Computed: number of volunteers (reports)
 */
class EducationLevel extends Model {

    protected $table = 'education_levels';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
