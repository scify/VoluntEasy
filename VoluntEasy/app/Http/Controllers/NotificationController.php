<?php namespace App\Http\Controllers;

use App\Models\User;
class NotificationController extends Controller {

    private \App\Services\NotificationService $notificationService;

    /////////////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                                  //
    //   1 = Volunteer is assigned to Unit (Unit-Users)                           //
    //   2 = Volunteer is deleted or unassigned (top Users)                      //
    //   3 = Volunteer is in the middle of actions period (parent Unit-Users)   //
    //   4 = action is expired ...   (parent Unit-Users)                       //
    //   4 = Volunteer submitted the Questionnaire (parent Unit-Users)        //
    //////////////////////////////////////////////////////////////////////////

    public function __construct(\App\Services\NotificationService $notificationService) {
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    public function index() {
        $user = User::where('id', \Auth::id())->with('notifications')->first();

        return view('main.notifications.list', compact('user'));
    }

    /**
     * stop the Bell Ring at a Notification Instance
     *
     * @param int $notificationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function stopBellNotification($notificationId) {
        if ($this->notificationService->stopBellNotification($notificationId)) {
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
     * @param int $notificationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivateNotification($notificationId) {
        if ($this->notificationService->deactivateNotification($notificationId)) {
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
     * @return list<\App\Models\Notification> The active and the latest inactive notifications
     */
    public function checkForNotifications() {
        return $notificationsList = $this->notificationService->checkForNotifications();
    }

}
