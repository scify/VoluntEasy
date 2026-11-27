<?php

namespace App\Models\Descriptions;

use App\Models\Model;

class CommunicationMethod extends Model
{
    protected $table = 'comm_method';

    protected $fillable = ['description'];

    public function getDescriptionAttribute()
    {
        return trans('database/db_tables.'.$this->attributes['description']);
    }
}
