<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Model;
use App\Models\User;

/**
 * An Eloquent Model: 'Notification'
 * this table is checked every 1 minute with Ajax request in order to notify the user for an action
 * (possible actions: ring a bell, acctivate a red sighn on NavBar, etc..)
 * 
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $type_id What the notification is about (see the index below)
 * @property int $reference1_id The id of the model that the notification is about
 * @property int|null $reference2_id A second model id, if necessary
 * @property string|null $status Notification state: active, alarmAndActive or inactive
 */
class Notification extends Model
{

    //////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                           //
    //   1 = Volunteer is assighned to Unit (Unit-Users)                    //
    //   2 = Volunteer is deleted or unAssighned (top Users)                //
    //   3 = Voluteer is in the midle of actions period (parent Unit-Users) //
    //   4 = action is expired ...   (parent Unit-Users)                    //
    //   4 = Volunteer submited the Questionare (parent Unit-Users)         //
    //////////////////////////////////////////////////////////////////////////

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';
	protected $fillable = array('user_id', 'type_id', 'msg', 'url', 'reference1_id', 'reference2_id', 'status');

    ////////////////////////
    //  *** RELATIONS *** //
    ////////////////////////

	// User __one to many__ Notifications
	/** @return BelongsTo<\App\Models\User, $this> */
	public function user(): BelongsTo {
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}
}
