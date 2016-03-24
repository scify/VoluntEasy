<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;

class ActionRating extends Model {
    
    protected $table = 'action_ratings';

    protected $fillable = ['action_id', 'user_id', 'email', 'token', 'rated'];

    public function volunteerRatings()
    {
        return $this->hasMany('App\Models\Rating\VolunteerActionRating', 'action_rating_id', 'id');
    }

    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
