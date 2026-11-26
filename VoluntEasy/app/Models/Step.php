<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Model;
class Step extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $table = 'steps';

    protected $fillable = ['description', 'step_order', 'type'];

    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

    /** @return HasManyThrough<\App\Models\Descriptions\StepStatus, \App\Models\VolunteerStepStatus, $this> */
    public function status(): HasManyThrough {
        return $this->hasManyThrough(\App\Models\Descriptions\StepStatus::class, \App\Models\VolunteerStepStatus::class, 'step_status_id', 'id');
    }

    /** @return HasMany<\App\Models\VolunteerStepStatus, $this> */
    public function statuses(): HasMany {
        return $this->hasMany(\App\Models\VolunteerStepStatus::class, 'step_id', 'id');
    }

}
