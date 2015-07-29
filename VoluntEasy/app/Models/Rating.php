<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {
    
    protected $table = 'ratings';

    protected $fillable = ['volunteer_id', 'rating_attr1', 'rating_attr1_count', 
        'rating_attr2', 'rating_attr2_count', 'rating_attr3', 'rating_attr3_count'];


    ///////////////
    // Relations //
    ///////////////
    
    public function volunteer()
    {
        return $this->belongsTo('App\Models\Volunteer');
    }
}
