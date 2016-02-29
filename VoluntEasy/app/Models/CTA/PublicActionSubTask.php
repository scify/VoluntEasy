<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;


class PublicActionSubTask extends Model {

    protected $table = 'public_actions_subtasks';

    protected $fillable = ['description', 'public_actions_id', 'subtask_id'];


    public function subtask(){
        return $this->hasOne('App\Models\ActionTasks\SubTask', 'id', 'subtask_id');
    }
}
