<?php namespace App\Models\Descriptions;

use App\Models\Model;
class AvailabilityFrequencies extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'availability_freqs';

    protected $fillable = ['description'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }
}
