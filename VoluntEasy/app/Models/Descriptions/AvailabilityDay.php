<?php namespace App\Models\Descriptions;

use App\Models\Model;
class AvailabilityDay extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'availability_days';

    protected $fillable = ['day', 'time', 'volunteer_id'];

 }
