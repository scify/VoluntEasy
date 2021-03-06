<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class StepStatus extends Model {

    protected $table = 'step_statuses';

    protected $fillable = ['description'];

    public function scopeIncomplete(){
        return $this->where('description', 'Incomplete')->first()->id;
    }

}
