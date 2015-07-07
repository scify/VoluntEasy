<?php

Route::get('/', 'HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);



//User Routes
Route::get('users','UserController@index');
Route::get('users/one/{id}', ['as' => 'user/profile', 'uses' => 'UserController@show']);
Route::get('users/create', 'UserController@create');
Route::get('users/edit/{id}', 'UserController@edit');
Route::post('users/delete/{id}', 'UserController@destroy');
Route::post('users/update', 'UserController@update');
Route::post('users/store', 'UserController@store');
Route::post('users/units', 'UserController@addUnits');


//Unit Routes
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




//Volunteer Routes
Route::get('volunteers','VolunteerController@index');
Route::get('volunteers/all','VolunteerController@all');
Route::get('volunteers/new','VolunteerController@getNew');
Route::get('volunteers/create', 'VolunteerController@create');
Route::post('volunteers/store', 'VolunteerController@store');
Route::post('volunteers/search', 'VolunteerController@search');

/**  test remove */
Route::get('volunteers/new','TestController@newVolunteers');



//Action Routes
Route::get('actions','ActionController@index');
Route::get('actions/one/{id}', ['as' => 'action/one', 'uses' => 'ActionController@show']);
Route::get('actions/create', 'ActionController@create');
Route::get('actions/edit/{id}', 'ActionController@edit');
Route::get('actions/delete/{id}', 'ActionController@destroy');
Route::post('actions/store', 'ActionController@store');
Route::post('actions/update', 'ActionController@update');
Route::post('actions/volunteers', 'ActionController@addVolunteers');


//Step Routes
Route::get('steps/volunteer/{id}','StepController@volunteerSteps');








// Route to view logs in a more human way
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');



/** TESTS **/
Route::get('test','TestController@test');



/** aris TESTing... **/
Route::get('aris', function()
{
	// return \Unit::first();

		// return Mail::send('emails.testmail', array(),function ($m) {
  //           $m->to('aris.stru@gmail.com', 'Aris')->subject('testinggggg');
  //       });    
});

