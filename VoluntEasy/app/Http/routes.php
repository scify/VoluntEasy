<?php

Route::get('/', 'WelcomeController@index');


Route::get('main','HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('main/actionsPrograms/actionListing','MenuController@b1');
Route::get('main/actionsPrograms/listview','MenuController@b2');
Route::get('main/actionsPrograms/modifications','MenuController@b3');
Route::get('main/actionsPrograms/overview','MenuController@b4');

Route::get('main/volunteers/listview','MenuController@c1');
Route::get('main/volunteers/statistics','MenuController@c2');

//User Routes
Route::get('main/users','UserController@index');
Route::get('main/users/one/{id}', 'UserController@show');
Route::get('main/users/create', 'UserController@create');
Route::get('main/users/edit/{id}', 'UserController@edit');
Route::get('main/users/delete/{id}', 'UserController@destroy');
Route::post('main/users/update', 'UserController@update');
Route::post('main/users/store', 'UserController@store');

//Unit Routes
Route::get('main/units','UnitController@index');
Route::get('main/units/tree/{id}','UnitController@tree');
Route::get('main/units/one/{id}', 'UnitController@show');
Route::get('main/units/create', 'UnitController@createRoot');
Route::get('main/units/create/{id}', 'UnitController@createBranch');
Route::get('main/units/edit/{id}', 'UnitController@edit');
Route::get('main/units/delete/{id}', 'UnitController@destroy');
Route::post('main/units/store', 'UnitController@store');
Route::post('main/units/update', 'UnitController@update');



Route::get('main/users/listview','MenuController@d2');
Route::get('main/users/modifications','MenuController@d3');
Route::get('main/users/overview','MenuController@d4');

Route::get('main/sitemap/sitemap','MenuController@e1');


// Route to view logs in a more human way
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');



/** TESTS **/
Route::get('main/test','UnitController@test');
