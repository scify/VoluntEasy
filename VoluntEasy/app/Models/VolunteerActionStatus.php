<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VolunteerActionStatus extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_action_status';



    public function actions()
    {
        return $this->hasMany('App\Models\Actions');
    }


    public function actionsStatuses()
    {
        return $this->hasMany('App\Models\Descriptions\ActionStatus');
    }


}
