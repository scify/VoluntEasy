<?php namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * An Eloquent Model: 'Notification'
 * this table is checked every 1 minute with Ajax request in order to notify the user for an action
 * (possible actions: ring a bell, acctivate a red sighn on NavBar, etc..)
 * 
 * @property integer-increment $id
 * @property created_at
 * @property updated_at
 * @property integer-ForeignKey $userId
 * @property typeId ->index //  what the notification is about
 * @property reference1Id ->index // the Model instance id that we have o locate 
 * @property reference2Id ->nullable // a second Model instance id that maybe we have o locate
 * @property status -> size(30) ->nullable  // what notification action (ring a bell, print red button on NavBar, etc..)
 *
 * @relations belongs to One User
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
	protected $fillable = array('userId', 'typeId', 'reference1Id', 'reference2Id', 'status');


    ////////////////////////
    //  *** RELATIONS *** //
    ////////////////////////

	// User __one to many__ Notifications
	public function user()
	{
		return $this->belongsTo('App\Models\User', 'userId');
	}

}