<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class VolunteerStatusDuration extends Model {

    protected $table = 'volunteer_status_duration';

    protected $fillable = ['from_date', 'to_date', 'volunteer_id', 'status_id', 'comments'];


}
