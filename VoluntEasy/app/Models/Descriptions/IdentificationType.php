<?php namespace App\Models\Descriptions;

use App\Models\Model;
class IdentificationType extends Model {

    protected $table = 'identification_types';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
