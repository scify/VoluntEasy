<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PublicActionSubTask extends Model {

    use SoftDeletes;

    protected $table = 'public_actions_subtasks';

    protected $fillable = ['description', 'public_actions_id', 'subtask_id'];

    protected $dates = ['deleted_at'];

    public function subtask(){
        return $this->hasOne('App\Models\ActionTasks\SubTask', 'id', 'subtask_id');
    }
}
