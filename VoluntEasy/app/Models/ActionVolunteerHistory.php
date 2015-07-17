<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ActionVolunteerHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'actions_volunteers_history';

    protected $fillable = ['volunteer_id', 'action_id'];

}
