<?php

Route::get('main','IndexPage@mainIndex');

Route::get('main/orgUnits/unitEntry','MenuController@a1');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
