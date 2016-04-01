<?php

Route::get('/', 'HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


////////////////
//User Routes //
////////////////
Route::get('users', 'UserController@index');
Route::get('users/one/{id}', ['as' => 'user/profile', 'uses' => 'UserController@show']);
Route::get('users/one/{id}/tasks', ['as' => 'user/tasks', 'uses' => 'UserController@tasks']);
Route::get('users/create', 'UserController@create');
Route::get('users/edit/{id}', 'UserController@edit');
Route::get('users/delete/{id}', 'UserController@destroy');
Route::post('users/update', 'UserController@update');
Route::post('users/store', 'UserController@store');
Route::post('users/units', 'UserController@addUnits');
Route::post('users/search', 'UserController@search');


////////////////
//Unit Routes //
////////////////
Route::get('units', ['as' => 'units', 'uses' => 'UnitController@index']);
Route::get('units/tree/{id}', 'UnitController@tree');
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
Route::get('rootUnit', 'UnitController@rootUnit');
Route::get('wholeTree', 'UnitController@wholeTree');


/////////////////////
//Volunteer Routes //
/////////////////////
Route::get('volunteers', 'VolunteerController@index');
Route::get('volunteers/create', 'VolunteerController@create');
Route::get('volunteers/new', 'VolunteerController@newVolunteers');
Route::get('volunteers/edit/{id}', 'VolunteerController@edit');
Route::get('volunteers/delete/{id}', 'VolunteerController@destroy');
Route::get('volunteers/one/{id}', ['as' => 'volunteer/profile', 'uses' => 'VolunteerController@show']);
Route::get('volunteers/addToRootUnit/{id}', 'VolunteerController@addToRootUnit');
Route::get('volunteers/{volunteerId}/unit/detach/{unitId}', 'VolunteerController@detachFromUnit');
Route::get('volunteers/{volunteerId}/action/detach/{unitId}', 'VolunteerController@detachFromAction');
Route::post('volunteers/addToUnit', 'VolunteerController@addToUnit');
Route::post('volunteers/addToAction', 'VolunteerController@addToAction');
Route::post('volunteers/store', 'VolunteerController@store');
Route::post('volunteers/update', 'VolunteerController@update');
Route::post('volunteers/stepStatus/update', 'VolunteerController@updateStepStatus');
Route::post('volunteers/search', 'VolunteerController@search');
Route::post('volunteers/blacklisted', 'VolunteerController@blacklisted');
Route::post('volunteers/unblacklisted', 'VolunteerController@unBlacklisted');
Route::post('volunteers/notAvailable', 'VolunteerController@notAvailable');
Route::post('volunteers/available', 'VolunteerController@available');
Route::post('volunteers/deleteFile', 'VolunteerController@deleteFile');
Route::get('volunteers/publicForm', 'VolunteerController@publicForm');


//////////////////
//Action Routes //
//////////////////
Route::get('actions', 'ActionController@index');
Route::get('actions/one/{id}', ['as' => 'action/one', 'uses' => 'ActionController@show']);
Route::get('actions/create', 'ActionController@create');
Route::get('actions/edit/{id}', 'ActionController@edit');
Route::get('actions/delete/{id}', 'ActionController@destroy');
Route::post('actions/store', 'ActionController@store');
Route::post('actions/update', 'ActionController@update');
Route::post('actions/volunteers', 'ActionController@addVolunteers');
Route::get('actions/ratings/{id}', 'ActionController@fullRatings');
Route::post('actions/search', 'ActionController@search');


////////////////
//Task Routes //
////////////////
Route::get('actions/tasks/one/{id}', 'TaskController@show');
Route::post('actions/tasks/store', 'TaskController@store');
Route::get('actions/tasks/update', 'TaskController@update');
Route::get('actions/tasks/delete/{id}', 'TaskController@destroy');


////////////////////
//SubTask Routes //
//////////////////
Route::get('actions/tasks/subtasks/one/{id}', 'SubTaskController@show');
Route::post('actions/tasks/subtasks/store', 'SubTaskController@store');
Route::post('actions/tasks/subtasks/update', 'SubTaskController@update');
Route::get('actions/tasks/subtasks/updateStatus', 'SubTaskController@updateStatus');
Route::get('actions/tasks/subtasks/delete/{id}', 'SubTaskController@destroy');


////////////////////
//WorkDate Routes //
//////////////////
Route::get('actions/tasks/subtasks/workdates/store', 'WorkDateController@store');
Route::get('actions/tasks/subtasks/workdates/update', 'WorkDateController@update');
Route::get('actions/tasks/subtasks/workdates/delete/{id}', 'WorkDateController@destroy');


//////////////////////////
//Collaboration Routes //
////////////////////////
Route::get('collaborations', 'CollaborationController@index');
Route::get('collaborations/one/{id}', ['as' => 'collaboration/one', 'uses' => 'CollaborationController@show']);
Route::get('collaborations/create', 'CollaborationController@create');
Route::get('collaborations/edit/{id}', 'CollaborationController@edit');
Route::get('collaborations/delete/{id}', 'CollaborationController@destroy');
Route::post('collaborations/store', 'CollaborationController@store');
Route::post('collaborations/update', 'CollaborationController@update');
Route::post('collaborations/search', 'CollaborationController@search');
Route::post('collaborations/deleteFile', 'CollaborationController@deleteFile');


////////////////
//Step Routes //
////////////////
Route::get('steps/volunteer/{id}', 'StepController@volunteerSteps');


////////////////
//Rating Routes //
////////////////
Route::post('ratings/action/store', 'RatingController@storeActionRating');
Route::post('ratings/action/volunteers/store', 'RatingController@storeVolunteersRating');
Route::get('ratings/action/thankyou/{actionId}', 'RatingController@actionThankyou');
Route::get('ratings/action/volunteers/thankyou/{actionId}', 'RatingController@volunteersThankyou');
Route::get('ratings/action/{token}', 'RatingController@rateAction');
Route::get('rateVolunteers/{token}', 'RatingController@rateVolunteers');

////////////////////
// Notifications //
////////////////////	
Route::get('/addNotification/{userId}/{typeId}/{msg}/{url}/{reference1Id}/{reference2Id?}', array(
    'as' => 'notifications.add',
    'uses' => 'NotificationController@addNotification'
));

Route::get('stopBellNotification/{notificationId}', array(
    'as' => 'notifications.stopBell',
    'uses' => 'NotificationController@stopBellNotification'
));
Route::get('/deactivateNotification/{notificationId}', array(
    'as' => 'notification.deactivate',
    'uses' => 'NotificationController@deactivateNotification'
));
Route::get('/checkForNotifications', array(
    'as' => 'notifications.check',
    'uses' => 'NotificationController@checkForNotifications'
));
Route::get('notifications', 'NotificationController@index');


/////////////////
//Search Route //
/////////////////
Route::get('search/city', 'SearchController@city');
Route::get('search/country', 'SearchController@country');
Route::get('search/actionUser', 'SearchController@actionUser');
Route::get('search/collabType', 'SearchController@collabType');
Route::get('search/volunteers/firstName', 'SearchController@volunteerFirstName');
Route::get('search/volunteers/lastName', 'SearchController@volunteerLastName');


///////////////////
//Reports Routes //
//////////////////
Route::get('reports', 'ReportsController@index');
Route::get('reports/idleVolunteers', 'ReportsController@idleVolunteers');
Route::get('reports/volunteersByMonth', 'ReportsController@volunteersByMonth');
Route::get('reports/volunteersBySex', 'ReportsController@volunteersBySex');
Route::get('reports/volunteersByAgeGroup', 'ReportsController@volunteersByAgeGroup');
Route::get('reports/volunteersByCity', 'ReportsController@volunteersByCity');
Route::get('reports/volunteersByEducationLevel', 'ReportsController@volunteersByEducationLevel');
Route::get('reports/volunteersByInterest', 'ReportsController@volunteersByInterest');
Route::get('reports/volunteersByAction', 'ReportsController@volunteersByAction');
Route::get('reports/volunteerHoursByAction', 'ReportsController@volunteerHoursByAction');



///////////////////
//CTA Routes //
//////////////////
Route::get('cta', 'CTAController@cta');
Route::get('participate/{id}', 'CTAController@participate');
Route::get('cta/store', 'CTAController@store');
Route::get('cta/update', 'CTAController@update');
Route::post('cta/volunteerInterested', 'CTAController@volunteerInterested');


///////////////////
//CTAVolunteer Routes //
//////////////////
Route::get('ctaVolunteer/update', 'CTAVolunteerController@update');
Route::get('ctaVolunteer/delete/{id}', 'CTAVolunteerController@destroy');
Route::get('ctaVolunteer/assignToVolunteer', 'CTAVolunteerController@assignToVolunteer');



///////////////////
//Checklist Routes //
//////////////////
Route::get('checklist/store', 'ChecklistController@store');
Route::get('checklist/update', 'ChecklistController@update');
Route::get('checklist/delete', 'ChecklistController@delete');




/////////////////
//API Routes //
/////////////////
Route::group(['middleware' => 'cors', 'prefix' => 'api'], function () {
    Route::get('volunteers', 'Api\VolunteerApiController@all');
    Route::get('volunteers/status/{status}', 'Api\VolunteerApiController@status');
    Route::get('volunteers/one/{id}', 'Api\VolunteerApiController@show');
    Route::post('volunteers/apiStore', 'Api\VolunteerApiController@apiStore');

    Route::get('units', 'Api\UnitApiController@all');
    Route::get('units/{id}/volunteers', 'Api\UnitApiController@volunteers');
    Route::get('units/{id}/actions', 'Api\UnitApiController@actions');

    Route::get('users', 'Api\UserApiController@all');

    Route::get('actions', 'Api\ActionApiController@all');
    Route::get('actions/{id}/volunteers', 'Api\ActionApiController@volunteers');
    Route::get('actions/calendar', 'Api\ActionApiController@calendar');
    Route::get('actions/rating/{id}', 'Api\ActionApiController@rating');

    Route::get('collaborations', 'Api\CollaborationApiController@all');

    Route::get('tree', 'Api\TreeApiController@tree');
    Route::get('tree/activeUnits/{id}', 'Api\TreeApiController@activeUnits');

});


Route::get('faq', 'EtcController@faq');


Route::get('cityofathens', 'TestController@cityofathens');


////////////////////////////////////////////
// Log Viewer                             //
// Route to view logs in a more human way //
////////////////////////////////////////////
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


////////////
// TESTS  //
////////////
Route::get('test', 'TestController@test');
Route::post('testPost', 'TestController@test');
Route::get('faker', 'TestController@faker');
Route::get('boxytree', 'TestController@boxytree');
Route::get('experiment', 'TestController@experiment');


Route::get('ekpizo', 'TestController@ekpizo');


// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function ($query) {
    //var_dump($query);
});


