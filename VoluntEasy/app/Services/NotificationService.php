<?php namespace App\Services;

use App\Models\Action;
use App\Models\Notification;
use App\Models\Unit;
use App\Services\Facades\UserService;

/**
 * The PHP Class that will handle the business logic for the Notification Engine
 * [basic methods] -> [add,remove,search]
 */
class NotificationService {

    //////////////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                                   //
    //   1 = User is assigned to Unit (Unit-Users)                                 //
    //   2 = Volunteer is assigned to unit (volunteers-units)                     //
    //   3 = Volunteer is deleted or unassigned                                  //
    //   4 = Action expires in 7 days                                           //
    //   5 = Action expired yesterday                                          //
    //   6 = Volunteer submitted the Questionnaire (parent Unit-Users)        //
    ///////////////////////////////////////////////////////////////////////////


    /** Messages **/
    private $userToUnit = 'Είστε υπεύθυνος της μονάδας ';
    private $newVolunteer = 'Ένας νέος εθελοντής ανατέθηκε στη μονάδα ';


    /**
     * create a new Notification Instance
     *
     * @param  [$userId] [which user it concerns]
     * @param [typeId] [check Index above]
     * @param reference1Id [the Model instance id that we have o locate ]
     * @param reference2Id [a second Model instance id that maybe we have o locate]
     *
     * @return int [success status]
     */
    public function addNotification($userId, $typeId, $msg, $url, $reference1Id, $reference2Id = null) {
        $notification = new Notification;
        $notification->userId = $userId;
        $notification->typeId = $typeId;
        $notification->msg = $msg;
        $notification->url = $url;
        $notification->reference1Id = $reference1Id;
        $notification->reference2Id = $reference2Id;
        $notification->status = 'alarmAndActive';

        if ($notification->save())
            return 1;
        else
            return 0;
    }

    /**
     * stop the Bell Ring at a Notification Instance
     *
     * @param [$notificationId]
     * @return int [success status]
     */
    public function stopBellNotification($notificationId) {
        $notification = Notification::findOrFail($notificationId);

        $notification->status = 'active';

        if (!$notification->save())
            return 0;

        return 1;
    }

    /**
     * deactivate a Notification Instance
     * so it is not appeared any more to the client
     * we deactivate and don't delete it for Data Mining reasons
     * @param [$notificationId] [a notifications instance Id we want to deactivate]
     *
     * @return int [success status]
     */
    public function deactivateNotification($notificationId) {
        $notification = Notification::findOrFail($notificationId);

        $notification->status = 'inactive';

        if (!$notification->save())
            return 0;

        return 1;
    }

    /**
     * !!! Notification Types Index on top of the page !!!
     * check if there is any active Notification for the specific User
     *
     * @return [mixed] [a list with all the active notification for the user]
     */
    public function checkForNotifications() {
        $userId = \Auth::user()->id;

        $actives = Notification::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere('status', 'alarmAndActive');
            })
            ->orderBy('created_at', 'desc')->get();


        //also get the first five inactive notifications
        $firstFive = Notification::where('user_id', $userId)
            ->where('status', 'inactive')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $notifications = [];

        foreach ($actives as $active) {
            // humanized date with use of Carbon Date package
            $active['when'] = $active->created_at->diffForHumans();

            unset($active['created_at']);
            unset($active['updated_at']);

            array_push($notifications, $active);
        }

        foreach ($firstFive as $inactive) {
            // humanized date with use of Carbon Date package
            $inactive['when'] = $inactive->created_at->diffForHumans();

            unset($inactive['created_at']);
            unset($inactive['updated_at']);

            array_push($notifications, $inactive);
        }

        return $notifications;
    }


    /**
     * Notify one user that s/he is assigned to a unit
     *
     * @param $userId
     * @param $unit
     */
    public function userToUnit($userId, $unit) {

        $url = '/users/one/'.$userId;

        //userId, type of notification, message, url, userId, unitId
        NotificationService::addNotification($userId, 1, $this->userToUnit . $unit->description . '.', $url, $userId, $unit->id);

        return;
    }

    /**
     * Notify multiple users that they are assigned to a unit
     *
     * @param $usersIds
     * @param $unit
     */
    public function usersToUnit($usersIds, $unit) {

        foreach ($usersIds as $user)
            $this->userToUnit($user, $unit);
        return;

    }

    /**
     * Notify all the users that are attached to a unit
     * that a new volunteer has been assigned to the unit.
     *
     * @param $volunteerId
     * @param $unitId
     */
    public function newVolunteer($volunteerId, $unitId) {

        $url = '/volunteers/one/'.$volunteerId;

        $unit = Unit::with('users')->find($unitId);

        foreach ($unit->users as $user) {
            NotificationService::addNotification($user->id, 2, $this->newVolunteer . $unit->description . '.', $url, $user->id, $unit->id);
        }
    }

    /**
     * Notify the users of a unit that an action expired yesterday
     *
     * @param $actionId
     */
    public function actionExpired($actionId) {

        $action = Action::find($actionId);
        $unit = Unit::with('users')->find($action->unit_id);

        $url = '/actions/one/'.$actionId;

        //notify the unit's users
        foreach ($unit->users as $user) {
            NotificationService::addNotification($user->id, 5, 'Η δράση ' . $action->description . ' έληξε στις ' . $action->end_date . '.', $url, $user->id, $action->id);
        }

        $admins = UserService::getAdmins();

        //also notify all the admins
        foreach ($admins as $admin) {
            NotificationService::addNotification($admin->id, 5, 'Η δράση ' . $action->description . ' έληξε στις ' . $action->end_date . '.', $url, $admin->id, $action->id);
        }

    }

    /**
     * Notify the users for actions that expire in 7 days
     *
     * @param $actionId
     */
    public function actionExpiresIn7Days($actionId) {

        $action = Action::find($actionId);
        $unit = Unit::with('users')->find($action->unit_id);

        $url = '/actions/one/'.$actionId;

        //notify the unit's users
        foreach ($unit->users as $user) {
            NotificationService::addNotification($user->id, 6, 'Η δράση ' . $action->description . ' λήγει στις ' . $action->end_date . '.', $url, $user->id, $action->id);
        }

        $admins = UserService::getAdmins();

        //also notify all the admins
        foreach ($admins as $admin) {
            NotificationService::addNotification($admin->id, 6, 'Η δράση ' . $action->description . ' λήγει στις ' . $action->end_date . '.', $url, $admin->id, $action->id);
        }
    }
}
