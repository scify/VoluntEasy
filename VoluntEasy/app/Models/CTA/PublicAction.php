<?php namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The fields that will be displayed in the public cta page
 *
 * Class PublicAction
 * @package App\Models
 */
class PublicAction extends Model {

    protected $table = 'public_actions';

    protected $fillable = ['description', 'address', 'map_url', 'executive_name', 'executive_email', 'executive_phone', 'public_url', 'isActive', 'action_id'];


    public function action() {
        return $this->belongsTo('App\Models\Action', 'action_id', 'id');
    }

    public function subtasks(){
        return $this->hasMany('App\Models\CTA\PublicActionSubTask', 'public_actions_id', 'id');
    }

}
