<?php namespace App\Models;


class VolunteerStepHistory extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_step_history';

    protected $fillable = ['volunteer_id', 'step_id', 'previous_step_status_id', 'new_step_status_id', 'date'];


}
