<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerStepStatus extends Model {

    use \SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_step_status';

    protected $fillable = ['step_id', 'step_status_id'];


    public function step()
    {
        return $this->belongsTo('App\Models\Step');
    }


    public function status()
    {
        return $this->belongsTo('App\Models\Descriptions\StepStatus', 'step_status_id', 'id');
    }


    public function volunteer()
    {
        return $this->belongsTo('App\Models\Volunteer');
    }


}
