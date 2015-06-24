<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model {

    protected $table = 'actions';

    protected $fillable = ['description', 'comments', 'start_date', 'end_date', 'unit_id', 'email'];


    public function unit()
    {
        return $this->belongsToOne('App\Models\Unit');
    }


    public function volunteers()
    {
        return $this->belongsToMany('App\Models\Volunteer');
    }
}
