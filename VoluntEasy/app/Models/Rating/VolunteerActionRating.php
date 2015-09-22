<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;

class VolunteerActionRating extends Model {
    
    protected $table = 'volunteer_action_ratings';

    protected $fillable = ['volunteer_id', 'action_rating_id'];


    public function ratings()
    {
        return $this->hasOne('App\Models\Rating\Rating', 'volunteer_action_rating', 'id');
    }

    public function volunteer()
    {
        return $this->belongsTo('App\Models\Volunteer');
    }
}
