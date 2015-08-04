<?php namespace App\Services;

use App\Models\Notification;

/**
 * The PHP Class that will handle the buisnes logic for the Notification Engine
 * [basic methods] -> [add,remove,search]
 */
class NotificationService {

    /////////////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                                  //
    //   1 = Volunteer is assigned to Unit (Unit-Users)                           //
    //   2 = Volunteer is deleted or unassigned (top Users)                      //
    //   3 = Volunteer is in the middle of actions period (parent Unit-Users)   //
    //   4 = action is expired ...   (parent Unit-Users)                       //
    //   4 = Volunteer submitted the Questionnaire (parent Unit-Users)        //
    ///////////////////////////////////////////////////////////////////////////


    private $userToUnit = 'Είστε υπεύθυνος της μονάδας ';


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
     * @return int [succes status]
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
     * @param [$userId] [the User]
     * @return [collection] [a list with all the active notification for the user]
     */
    public function checkForNotifications() {
        $userId = \Auth::user()->id;

        $notificationObjectsList = Notification::whereStatus('active')->orWhere('status', 'alarmAndActive')
            ->whereHas('user', function ($q) use ($userId) {
                $q->whereId($userId);

            })->orderBy('created_at', 'desc')->get();


        foreach ($notificationObjectsList as $notificationObject) {
            // humanised date with Helper script
            //$humanDateTime = new Helper;
            //$notificationObject['when'] = $humanDateTime->dateDiff($notificationObject->created_at);

            // hummanised date with use of Carbon Date package
            $notificationObject['when'] = $notificationObject->created_at->diffForHumans();

            unset($notificationObject['created_at']);
            unset($notificationObject['updated_at']);

            //URL::to('transferRequest', $booking->id),
            //$temp = $notificationObject->created_at->diff(new \DateTime('now'));
        }

        return $notificationObjectsList;
    }



    /**
     * Notify one user that s/he is assigned to a unit
     *
     * @param $user
     * @param $unit
     */
    public function userToUnit($user, $unit) {

        $url = route('user/profile', ['id' => $user->id]);

        //userId, type of notification, message, url, userId, unitId
        NotificationService::addNotification($user->id, 1, $this->userToUnit . $unit->description, $url, $user->id, $unit->id);
        return;
    }

    /**
     * Notify multiple users that they are assigned to a unit
     *
     * @param $users
     * @param $unit
     */
    public function usersToUnit($users, $unit) {
        foreach ($users as $user)
            $this->userToUnit($user, $unit);
        return;
    }
}
