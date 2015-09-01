<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VolunteerStatusDuration extends Model {

    use SoftDeletes;

    protected $table = 'volunteer_status_duration';

    protected $fillable = ['from_date', 'to_date', 'volunteer_id', 'status_id', 'comments'];


    public function status() {
        return $this->hasOne('App\Models\Descriptions\VolunteerStatus', 'id', 'status_id');
    }

    public function getFromDateAttribute() {
        return \Carbon::parse($this->attributes['from_date'])->format('d/m/Y');
    }

    public function getToDateAttribute() {
        return \Carbon::parse($this->attributes['to_date'])->format('d/m/Y');
    }

}
