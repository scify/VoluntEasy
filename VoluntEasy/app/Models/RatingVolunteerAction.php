<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingVolunteerAction extends Model {
    
    protected $table = 'rating_volunteer_action';

    protected $fillable = ['volunteer_id', 'action_id', 'email', 'token'];


    public function ratings()
    {
        return $this->hasOne('App\Models\Descriptions\Rating', 'rating_volunteer_action_id', 'id');
    }

    public function volunteer()
    {
        return $this->belongsTo('App\Models\Volunteer');
    }

    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }
}
