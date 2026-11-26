<?php namespace App\Models\CTA;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PublicActionSubTask extends Model {

    use SoftDeletes;

    protected $table = 'public_actions_subtasks';

    protected $fillable = ['description', 'public_actions_id', 'subtask_id'];


    /** @return HasOne<\App\Models\ActionTasks\SubTask, $this> */
    public function subtask(): HasOne {
        return $this->hasOne(\App\Models\ActionTasks\SubTask::class, 'id', 'subtask_id');
    }
}
