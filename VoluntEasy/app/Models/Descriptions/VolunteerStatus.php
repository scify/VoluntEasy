<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class VolunteerStatus extends Model {

    protected $table = 'volunteer_statuses';

    protected $fillable = ['description'];

}
