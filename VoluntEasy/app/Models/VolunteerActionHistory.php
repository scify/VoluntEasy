<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VolunteerActionHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_action_history';

    protected $fillable = ['volunteer_id', 'action_id', 'user_id', 'created'];


    public function action() {
        return $this->hasOne('App\Models\Action', 'id', 'action_id');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }


}
