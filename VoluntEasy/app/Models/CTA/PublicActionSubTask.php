<?php

namespace App\Models\CTA;

use App\Models\ActionTasks\SubTask;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicActionSubTask extends Model
{
    use SoftDeletes;

    protected $table = 'public_actions_subtasks';

    protected $fillable = ['description', 'public_actions_id', 'subtask_id'];

    /** @return HasOne<SubTask, $this> */
    public function subtask(): HasOne
    {
        return $this->hasOne(SubTask::class, 'id', 'subtask_id');
    }
}
