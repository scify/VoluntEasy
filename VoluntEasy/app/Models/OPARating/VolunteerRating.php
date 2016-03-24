<?php namespace App\Models\OPARating;

use Illuminate\Database\Eloquent\Model;

class VolunteerRating extends Model {

    protected $table = 'volunteer_opa_ratings';

    protected $fillable = ['actionDescription', 'problemsOccured', 'fieldsToImprove', 'training', 'objectives', 'support', 'generalComments', 'user_id', 'volunteer_id'];


    public function laborSkills(){
        return $this->hasMany('App\Models\OPARating\VolunteerInterpersonalSkill', 'opa_rating_id', 'id');
    }

    public function interpersonalSkills(){
        return $this->hasMany('App\Models\OPARating\VolunteerInterpersonalSkill', 'opa_rating_id', 'id');
    }

}
