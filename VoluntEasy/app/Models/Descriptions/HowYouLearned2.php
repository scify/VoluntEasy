<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class HowYouLearned2 extends Model {

    protected $table = 'how_you_learned2';

    protected $fillable = ['description', 'comments'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

}
