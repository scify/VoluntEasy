<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VolunteerUnitHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_unit_history';

    protected $fillable = ['volunteer_id', 'unit_id', 'user_id', 'created'];


    public function unit(){
        return $this->hasOne('App\Models\Unit', 'id', 'unit_id');
    }


    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
