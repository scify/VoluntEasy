<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VolunteerActionHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_action_history';

    protected $fillable = ['volunteer_id', 'action_id', 'previous_action_status_id', 'new_action_status_id'];


}
