<?php namespace App\Http\Controllers;
 
use App\Models\Notification;
use App\Services\Facades\NotificationService;

Class NotificationController extends Controller {

    ///////////////////////////////////////////////////
    //   Notification Types Index                    //
    //   1 = new Request from Shipper To Transporter //
    //   2 = request Rejected from Transporter       //
    //   3 = request Rejected from Transporter       //
    //   4 = request Approved from Transporter       //
    ///////////////////////////////////////////////////


    /**
     * create a new Notification Instance
     * 
	 * @param  [$userId] [which user it concerns]
     * @param [$bookingId] [the booking the notification is about]
     * @param [typeId] [check Index above]
     * @return [boolean] [success status]
     */
    public function addNotification($userId, $bookingId, $typeId) 
    {
		$not = new NotificationManager;
		return $not->addNotification($userId, $bookingId, $typeId);
    }
    
    /**
     * deactivate a Notification Instance
     * so it is not appear any more to the client
     * we deactivate and don't delete it for Data Mining reasons
     * @param [$notificationIdsList] [a collection with the notification records we want to deactivate] [listSize-> 1 - many]
     * @return [boolean] [success status]
     */
    public function deactivateNotification($notificationId)
    {
    	$userId = Auth::user()->id;
		$notificationManager = new NotificationManager;		

		if ($notificationManager->deactivateOneNotification($notificationId))
			$status = 'success';
		else 
			$status = 'error';

		$response = array(
            'status' =>  'success', 
            'msg' => 'it is deactivated',
        );
 
        return Response::json( $response );
    }

    /**
     * check if there is any active Notification for the specific User
     * 
     * @param [$userId] [the User]
     * @return [collection] [a list with all the ]
     */
    public function checkForNotifications() 
    {
        if (Auth::check()) {
		  $userId = Auth::user()->id;
		  $notificationManager = new NotificationManager;		
		  $notificationsList = $notificationManager->checkForNotification($userId);

		  $response = array(
            'status' => 'success',
            'numberOfNotifications' => sizeof($notificationsList),
            'notificationsList' => $notificationsList,
            );

        }
        else {
            $response = array(
            'status' => 'error',
            'numberOfNotifications' => 0,
            'notificationsList' => 'not loged in',
            ); }
        return Response::json( $response );
    }

    /**
     * stop the Bell Ring at a Notification Instanse
     * @param [$notificationId]
     * @return [boolean] [succes status]
     */
    public function stopBellNotification($notificationId) 
    {
		$notificationManager = new NotificationManager;		

		if ($notificationManager->stopBellNotification($notificationId))
			$status = 'success';
		else 
			$status = 'error';

		$response = array(
            'status' =>  'success', 
            'msg' => 'it is deactivated',
        );
 
        return Response::json( $response );
    }
    


    /////////////////
    // for Testing //
    /////////////////

    /**
     * show a view with form to create settings
     */
    public function add() {
        return View::make( 'test' );
    }
 
    /**
     * handle data posted by ajax request
     */
    public function create() {
    
        //check if its our form
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
 
        $setting_name = Input::get( 'setting_name' );
        $setting_value = Input::get( 'setting_value' );
 
        //.....
        //validate data
        //and then store it in DB
        //.....
 
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
 
        return Response::json( $response );
    }

}