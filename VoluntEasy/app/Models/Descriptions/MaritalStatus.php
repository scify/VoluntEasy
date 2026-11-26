<?php namespace App\Models\Descriptions;

use App\Models\Model;
class MaritalStatus extends Model {

    protected $table = 'marital_statuses';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }
}
