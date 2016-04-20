<?php namespace App\Models\OPARating;

use Illuminate\Database\Eloquent\Model;

class VolunteerRating extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'volunteer_opa_ratings';

    protected $fillable = ['actionDescription', 'problemsOccured', 'fieldsToImprove', 'training', 'objectives', 'support', 'generalComments', 'user_id', 'volunteer_id', 'action_id', 'action_rating_id'];


    public function laborSkills(){
        return $this->hasMany('App\Models\OPARating\VolunteerLaborSkill', 'opa_rating_id', 'id');
    }

    public function interpersonalSkills(){
        return $this->hasMany('App\Models\OPARating\VolunteerInterpersonalSkill', 'opa_rating_id', 'id');
    }

    public function actionRating(){
        return $this->belongsTo('App\Models\Rating\ActionRating');
    }

    public function action(){
        return $this->belongsTo('App\Models\Action')->withTrashed();
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
