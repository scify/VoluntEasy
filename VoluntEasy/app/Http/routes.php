<?php

Route::get('/', 'WelcomeController@index');


Route::get('main','HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//User Routes
Route::get('main/users','UserController@index');
Route::get('main/users/one/{id}', ['as' => 'user/profile', 'uses' => 'UserController@show']);
Route::get('main/users/create', 'UserController@create');
Route::get('main/users/edit/{id}', 'UserController@edit');
Route::get('main/users/delete/{id}', 'UserController@destroy');
Route::post('main/users/update', 'UserController@update');
Route::post('main/users/store', 'UserController@store');
Route::post('main/users/units', 'UserController@addUnits');


//Unit Routes
Route::get('main/units','UnitController@index');
Route::get('main/units/tree/{id}','UnitController@tree');
Route::get('main/units/one/{id}', ['as' => 'unit/one', 'uses' => 'UnitController@show']);
Route::get('main/units/create', 'UnitController@create');
Route::get('main/units/create/{id}', 'UnitController@createBranch');
Route::get('main/units/edit/{id}', 'UnitController@edit');
Route::get('main/units/delete/{id}', 'UnitController@destroy');
Route::post('main/units/store', 'UnitController@store');
Route::post('main/units/update', 'UnitController@update');


//Volunteer Routes
Route::get('main/volunteers','VolunteerController@all');






//Action Routes
Route::get('main/actions','ActionController@index');
Route::get('main/actions/create', 'ActionController@create');






// Route to view logs in a more human way
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');



/** TESTS **/
Route::get('main/test','UnitController@test');
