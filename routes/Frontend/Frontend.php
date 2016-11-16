<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'
 */

Route::get('/', function () {
    return view('welcome');
});


/**
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('macros', 'FrontendController@macros')->name('macros');

    Route::get('home', 'FrontendController@index')->name('index');

	Route::group(['namespace' => 'User', 'as' => 'user.'], function() {
		/**
		 * User Dashboard Specific
		 */
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');

		/**
		 * User Account Specific
		 */
		Route::get('account', 'AccountController@index')->name('account');

		/**
		 * User Profile Specific
		 */
		Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
	});
});