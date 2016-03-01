<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model {

    protected $table = 'subtask_checklists';

    protected $fillable = ['comments', 'subtask_id', 'created_by', 'updated_by', 'isComplete'];

    public function createdBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    public function getCreatedAtAttribute() {
            return \Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    public function getUpdatedAtAttribute() {
        return \Carbon::parse($this->attributes['updated_at'])->format('d/m/Y');
    }
}
