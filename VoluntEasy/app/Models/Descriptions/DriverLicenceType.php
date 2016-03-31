<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class DriverLicenceType extends Model {

    protected $table = 'driver_license_types';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
