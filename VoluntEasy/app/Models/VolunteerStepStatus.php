<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Model;
class VolunteerStepStatus extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_step_status';

    protected $fillable = ['step_id', 'step_status_id', 'assignTo'];


    /** @return BelongsTo<\App\Models\Step, $this> */
    public function step(): BelongsTo {
        return $this->belongsTo(\App\Models\Step::class);
    }


    /** @return BelongsTo<\App\Models\Descriptions\StepStatus, $this> */
    public function status(): BelongsTo {
        return $this->belongsTo(\App\Models\Descriptions\StepStatus::class, 'step_status_id', 'id');
    }


    /** @return BelongsTo<\App\Models\Volunteer, $this> */
    public function volunteer(): BelongsTo {
        return $this->belongsTo(\App\Models\Volunteer::class);
    }


}
