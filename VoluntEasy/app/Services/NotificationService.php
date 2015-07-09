<?php namespace App\Services;
 
use App\Models\Notification;

/**
 * The PHP Class that will handle the buisnes logic for the Notification Engine
 * [basic methods] -> [add,remove,search]
 */
class NotificationService
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
     * create a new Notification Instanse
     * @param  [$userId] [wich user it concerns]
     * @param [typeId] [check Index above]
     * @param reference1Id [the Model instance id that we have o locate ]
     * @param reference2Id [a second Model instance id that maybe we have o locate]
     * @return [boolean] [succes status]
     */
    public function addNotification($userId, $typeId, $reference1Id, $reference2Id=null)
    {
        $notification = new Notification;
        $notification->userId = $userId;
        $notification->typeId = $typeId;
        $notification->reference1Id = $reference1Id;
        $notification->reference2Id = $reference2Id;
        $notification->status = 'alarmAndActive';

        if ($notification->save())
            return 1;
        else
            return 0;
    }

    /**
     * stop the Bell Ring at a Notification Instanse
     * @param [$notificationId] 
     * @return [boolean] [succes status]
     */
    public function stopBellNotification($notificationId) 
    {        
        $notification = Notification::findOrFail($notificationId);
        
        $notification->status = 'active';
        
        if (!$notification->save())
            return 0;

        return 1;
    }    

    /**
     * deactivate a Notification Instanse
     * so it is not appeared any more to the client 
     * we deactivate and don't delete it for Data Mining reasons
     * @param [$notificationId] [a notifications instance Id we want to deactivate]
     * @return [boolean] [succes status]
     */
    public function deactivateNotification($notificationId) 
    {
        $notification = Notification::findOrFail($notificationId);
        
        $notification->status = 'inactive';
        
        if (!$notification->save())
            return 0;

        return 1;
    }

    /**
     * !!! Notification Types Index on top of the page !!!
     * check if there is any active Notification for the specific User
     * @param [$userId] [the User]
     * @return [collection] [a list with all the active notification for the user]
     */
    public function checkForNotifications() 
    {        
        $userId = \Auth::user()->id;

        $notificationObjectsList = Notification::whereStatus('active')->orWhere('status','alarmAndActive')
        ->whereHas('user', function($q) use ($userId)
        {
            $q->whereId($userId);

        })->get();

        foreach ($notificationObjectsList as $notificationObject) {            
            $notificationObject['when'] = ;
            $notificationObject['msg'] = "testttt";
            $notificationObject['url'] = "testttt";    //URL::to('transferRequest', $booking->id),
        }

        return $notificationObjectsList;

    }
}      