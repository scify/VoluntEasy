<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class AvailabilityTime extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'availability_time';

    protected $fillable = ['description'];


}
