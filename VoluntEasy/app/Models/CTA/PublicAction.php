<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

/**
 * The fields that will be displayed in the public cta page
 *
 * Class Task
 * @package App\Models
 */
class PublicAction extends Model {

    protected $table = 'public_actions';

    protected $fillable = ['description', 'address', 'map_url', 'executive_name', 'executive_email', 'executive_phone', 'public_url', 'isActive', 'action_id'];


    public function action() {
        return $this->belongsTo('App\Models\Action', 'action_id', 'id');
    }

    public function subtasks(){
        return $this->belongsToMany('App\Models\ActionTasks\SubTask', 'public_actions_subtasks', 'public_actions_id', 'subtask_id');
    }

}
