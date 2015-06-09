<?php

Route::get('/', 'WelcomeController@index');


Route::get('main','HomeController@mainIndex');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('main/organizationalUnits/unitEntry','MenuController@a1');
Route::get('main/organizationalUnits/listview','MenuController@a2');
Route::get('main/organizationalUnits/modifications','MenuController@a3');
Route::get('main/organizationalUnits/overview','MenuController@a4');

Route::get('main/actionsPrograms/actionListing','MenuController@b1');
Route::get('main/actionsPrograms/listview','MenuController@b2');
Route::get('main/actionsPrograms/modifications','MenuController@b3');
Route::get('main/actionsPrograms/overview','MenuController@b4');

Route::get('main/volunteers/listview','MenuController@c1');
Route::get('main/volunteers/statistics','MenuController@c2');

Route::get('main/users','UserController@index');
Route::get('main/users/{id}', 'UserController@show');
Route::get('main/users/create', 'UserController@create');
Route::get('main/users/edit', 'UserController@edit');


Route::get('main/users/listview','MenuController@d2');
Route::get('main/users/modifications','MenuController@d3');
Route::get('main/users/overview','MenuController@d4');

Route::get('main/sitemap/sitemap','MenuController@e1');