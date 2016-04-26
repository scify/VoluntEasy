<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubtaskChecklist extends Model {

    use SoftDeletes;

    protected $table = 'subtask_checklists';

    protected $fillable = ['comments', 'subtask_id', 'created_by', 'updated_by', 'isComplete'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function createdBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    public function getCreatedAtAttribute() {
            return \Carbon::parse($this->attributes['created_at'])->format('H:i, d/m/Y');
    }

    public function getUpdatedAtAttribute() {
        return \Carbon::parse($this->attributes['updated_at'])->format('H:i, d/m/Y');
    }

}
