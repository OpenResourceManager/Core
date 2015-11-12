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

Route::get('/', function () {
    return Redirect::away(url('docs'));
});

Route::group(['prefix' => 'api'], function () {

    Route::get('/', function () {
        return Redirect::away(url('docs'));
    });

    Route::group(['prefix' => 'v1'], function () {

        Route::get('/', function () {
            return Redirect::away(url('docs'));
        });

        Route::resource('campus', 'CampusController');
        Route::resource('building', 'BuildingController');
        Route::resource('user', 'UserRecordController');
        Route::resource('room', 'RoomRecordController');
        Route::get('building/{id}/rooms', 'RoomRecordController@buildingRooms');
        Route::get('user/{id}/rooms', 'RoomRecordController@userRooms');
    });
});
