<?php namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;

class ActionRatingScore extends Model {
    
    protected $table = 'action_rating_scores';

    protected $fillable = ['score', 'attribute_id', 'action_score_id'];


    public function attribute()
    {
        return $this->hasOne('App\Models\Rating\ActionRatingAttribute', 'id', 'attribute_id');
    }
}
