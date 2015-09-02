<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VolunteerUnitStatus extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'volunteer_unit_status';

    protected $fillable = ['volunteer_id', 'unit_id', 'volunteer_status_id'];


    public function unit() {
        return $this->hasOne('App\Models\Unit', 'id', 'unit_id');
    }


    public function volunteer() {
        return $this->hasOne('App\Models\Volunteer', 'id', 'volunteer_id');
    }

    public function status() {
        return $this->hasOne('App\Models\Descriptions\VolunteerStatus', 'id', 'volunteer_status_id');
    }

}
