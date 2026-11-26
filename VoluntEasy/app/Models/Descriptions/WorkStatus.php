<?php namespace App\Models\Descriptions;

use App\Models\Model;
class WorkStatus extends Model {

    protected $table = 'work_statuses';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
