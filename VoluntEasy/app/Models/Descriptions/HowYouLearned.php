<?php namespace App\Models\Descriptions;

use App\Models\Model;
class HowYouLearned extends Model {

    protected $table = 'how_you_learned';

    protected $fillable = ['description', 'comments'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
