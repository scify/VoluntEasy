<?php namespace App\Models\ActionTasks;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubtaskChecklist extends Model {

    use SoftDeletes;

    protected $table = 'subtask_checklists';

    protected $fillable = ['comments', 'subtask_id', 'created_by', 'updated_by', 'isComplete'];

    /** @return HasOne<\App\Models\User, $this> */
    public function createdBy(): HasOne {
        return $this->hasOne(\App\Models\User::class, 'id', 'created_by');
    }

    /** @return HasOne<\App\Models\User, $this> */
    public function updatedBy(): HasOne {
        return $this->hasOne(\App\Models\User::class, 'id', 'updated_by');
    }

    public function getCreatedAtAttribute() {
            return \Carbon::parse($this->attributes['created_at'])->format('H:i, d/m/Y');
    }

    public function getUpdatedAtAttribute() {
        return \Carbon::parse($this->attributes['updated_at'])->format('H:i, d/m/Y');
    }

}
