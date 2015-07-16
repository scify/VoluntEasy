<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model {

    protected $table = 'steps';

    protected $fillable = ['description', 'step_order'];


    public function status(){
        return $this->hasManyThrough('App\Models\Descriptions\StepStatus', 'App\Models\VolunteerStepStatus', 'step_status_id', 'id');
    }




    /*
     *
        countries
            id - integer
            name - string

        users
            id - integer
            country_id - integer
            name - string

        posts
            id - integer
            user_id - integer
            title - string

    */

    //in country
    //        return $this->hasManyThrough('Post', 'User', 'country_id', 'user_id');


}
