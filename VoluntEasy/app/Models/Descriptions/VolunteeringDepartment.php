<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class VolunteeringDepartment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteering_departments';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
