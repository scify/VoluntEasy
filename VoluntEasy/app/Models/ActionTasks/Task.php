<?php namespace App\Models\ActionTasks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Describes the tasks that are needed for an action,
 * i.e  Action Bazaar needs 2 cashiers, 3 PR etc...
 *
 * Class Task
 * @package App\Models
 */
class Task extends Model {

    protected $table = 'actions';

    protected $fillable = ['description', 'name'];


    public function action() {
        return $this->belongsTo('App\Models\Action');
    }

}
