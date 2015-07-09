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

    public function volunteer()
    {
        return $this->belongsToMany('App\Models\Descriptions\VolunteerAvailabilityTime', 'volunteer_availability_times', 'availability_time_id', 'volunteer_id');
    }
}
