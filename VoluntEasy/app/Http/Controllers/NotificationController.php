<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Facades\NotificationService;

Class NotificationController extends Controller {

    /////////////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                                  //
    //   1 = Volunteer is assigned to Unit (Unit-Users)                           //
    //   2 = Volunteer is deleted or unassigned (top Users)                      //
    //   3 = Volunteer is in the middle of actions period (parent Unit-Users)   //
    //   4 = action is expired ...   (parent Unit-Users)                       //
    //   4 = Volunteer submitted the Questionnaire (parent Unit-Users)        //
    //////////////////////////////////////////////////////////////////////////

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = User::where('id', \Auth::user()->id)->with('notifications')->first();

        return view('main.notifications.list', compact('user'));
    }


    /**
     * create a new Notification Instance
     *
     * @param  [$userId] [which user it concerns]
     * @param [typeId] [check Index above]
     * @param reference1Id [the Model instance id that we have o locate ]
     * @param reference2Id [a second Model instance id that maybe we have o locate]
     * @return [boolean] [success status]
     */
    public function addNotification($userId, $typeId, $msg, $url, $reference1Id, $reference2Id = null) {
        return $not = NotificationService::addNotification($userId, $typeId, $msg, $url, $reference1Id, $reference2Id ?: null);
    }

    /**
     * stop the Bell Ring at a Notification Instance
     *
     * @param [$notificationId]
     * @return [boolean] [succes status]
     */
    public function stopBellNotification($notificationId) {
        if (NotificationService::stopBellNotification($notificationId)) {
            $status = 'success';
            $msg = 'the bell Sound is deactivated';
        } else {
            $status = 'error';
            $msg = 'could not change notification status';
        }

        $response = array(
            'status' => $status,
            'msg' => $msg
        );

        return \Response::json($response);
    }

    /**
     * deactivate a Notification Instance
     * so it is not appear any more to the client
     * we deactivate and don't delete it for Data Mining reasons
     *
     * @param [$notificationIdsList] [a collection with the notification records we want to deactivate] [listSize-> 1 - many]
     * @return [boolean] [success status]
     */
    public function deactivateNotification($notificationId) {
        if (NotificationService::deactivateNotification($notificationId)) {
            $status = 'success';
            $msg = 'notification is deactivated';
        } else {
            $status = 'error';
            $msg = 'could not deactivated notification';
        }

        $response = array(
            'status' => $status,
            'msg' => $msg
        );

        return \Response::json($response);
    }

    /**
     * check if there is any active Notification for the specific User
     *
     * @param [$userId] [the User]
     * @return [collection] [a list with all the ]
     */
    public function checkForNotifications() {
        return $notificationsList = NotificationService::checkForNotifications();
    }

}
