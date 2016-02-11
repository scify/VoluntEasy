<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class VolunteeringDepartment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteering_department';

    protected $fillable = ['description'];

}
