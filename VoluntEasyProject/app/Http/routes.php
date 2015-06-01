<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('main','IndexPage@mainIndex');

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

Route::get('main/users/userListing','MenuController@d1');
Route::get('main/users/listview','MenuController@d2');
Route::get('main/users/modifications','MenuController@d3');
Route::get('main/users/overview','MenuController@d4');

Route::get('main/sitemap/sitemap','MenuController@e1');