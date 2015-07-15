<?php

Route::get('/', 'HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


 
////////////////
//User Routes //
////////////////
Route::get('users','UserController@index');
Route::get('users/one/{id}', ['as' => 'user/profile', 'uses' => 'UserController@show']);
Route::get('users/create', 'UserController@create');
Route::get('users/edit/{id}', 'UserController@edit');
Route::post('users/delete/{id}', 'UserController@destroy');
Route::post('users/update', 'UserController@update');
Route::post('users/store', 'UserController@store');
Route::post('users/units', 'UserController@addUnits');


////////////////
//Unit Routes //
////////////////
Route::get('units', ['as' => 'units', 'uses' => 'UnitController@index']);
Route::get('units/tree/{id}','UnitController@tree');
Route::get('units/one/{id}', ['as' => 'unit/one', 'uses' => 'UnitController@show']);
Route::get('units/create', 'UnitController@create');
Route::get('units/edit/{id}', 'UnitController@edit');
Route::get('units/delete/{id}', 'UnitController@destroy');
Route::post('units/store', 'UnitController@store');
Route::post('units/update', 'UnitController@update');
Route::post('units/users', 'UnitController@addUsers');
Route::post('units/volunteers', 'UnitController@addVolunteers');
Route::post('units/search', 'UnitController@search');
Route::post('units/results', 'UnitController@results');
Route::get('wholeTree', 'UnitController@wholeTree');
Route::get('rootUnit', 'UnitController@rootUnit');




/////////////////////
//Volunteer Routes //
/////////////////////
Route::get('volunteers','VolunteerController@index');
Route::get('volunteers/all','VolunteerController@all');
Route::get('volunteers/new','VolunteerController@newVolunteers');
Route::get('volunteers/create', 'VolunteerController@create');
Route::get('volunteers/delete/{id}', 'VolunteerController@destroy');
Route::get('volunteers/one/{id}', ['as' => 'volunteer/one', 'uses' => 'VolunteerController@show']);
Route::post('volunteers/store', 'VolunteerController@store');
Route::post('volunteers/search', 'VolunteerController@search');


//////////////////
//Action Routes //
//////////////////
Route::get('actions','ActionController@index');
Route::get('actions/one/{id}', ['as' => 'action/one', 'uses' => 'ActionController@show']);
Route::get('actions/create', 'ActionController@create');
Route::get('actions/edit/{id}', 'ActionController@edit');
Route::get('actions/delete/{id}', 'ActionController@destroy');
Route::post('actions/store', 'ActionController@store');
Route::post('actions/update', 'ActionController@update');
Route::post('actions/volunteers', 'ActionController@addVolunteers');
Route::post('actions/search', 'ActionController@search');


////////////////
//Step Routes //
////////////////
Route::get('steps/volunteer/{id}','StepController@volunteerSteps');



////////////////////
// Notifications //
////////////////////	
Route::get('/addNotification/{userId}/{typeId}/{msg}/{url}/{reference1Id}/{reference2Id?}', array(
    'as' => 'notifications.add',
    'uses' => 'NotificationController@addNotification'
) );

Route::get('stopBellNotification/{notificationId}', array(
    'as' => 'notifications.stopBell',
    'uses' => 'NotificationController@stopBellNotification'
) );
Route::get('/deactivateNotification/{notificationId}', array(
    'as' => 'notification.deactivate',
    'uses' => 'NotificationController@deactivateNotification'
) );
Route::get( '/checkForNotifications', array(
    'as' => 'notifications.check',
    'uses' => 'NotificationController@checkForNotifications'
) );
Route::get('notifications','NotificationController@index');


/////////////////
//Search Route //
/////////////////
Route::get('search/city','SearchController@city');
Route::get('search/country','SearchController@country');


////////////////////////////////////////////
// Log Viewer                             //
// Route to view logs in a more human way //
////////////////////////////////////////////
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


////////////
// TESTS  //
////////////
Route::get('test','TestController@test');

/**  test remove */
Route::get('units/branch/{id}','UnitController@branch');

/** aris TESTing... **/
Route::get('aris', function()
{
    return  php_sapi_name();
    $user = Auth::user();
    $unit = App\Models\Unit::first(); 
    return App\Services\Facades\NotificationService::addNotification($user->id, 1, 'you are added to Unit: '.$unit->description, "athensIndymedia", $user->id, $unit->id);

    
    //Route::get('notifications.add', 'UserController@showProfile')
    //route('notifications.add');

    //$request = Request::create('/addNotification/'.$userId.'/1/you are added to Unit: '.'UNITNAME'.'/athens.indymedia/'.'1'.'/'.'2'.'/', 'GET');
    //return var_dump($this);
    //->client->get('http://volunteasy/addNotification/'.$userId.'/1/you are added to Unit: '
     //   .'UNITNAME'.'/athens.indymedia/'.'1'.'/'.'2'.'/');
    //return Route::dispatch($request);

    //return new \DateTime('today'); 
});

