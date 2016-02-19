<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model {

    protected $table = 'subtask_checklists';

    protected $fillable = ['comments', 'subtask_id', 'user_id'];

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
