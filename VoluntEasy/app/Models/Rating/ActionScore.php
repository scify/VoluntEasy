<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;

class ActionScore extends Model {
    
    protected $table = 'action_scores';

    protected $fillable = ['action_id', 'comments', 'token', 'rated'];


    public function ratings()
    {
        return $this->hasMany('App\Models\Rating\ActionRatingScore', 'action_score_id', 'id');
    }

    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }
}
