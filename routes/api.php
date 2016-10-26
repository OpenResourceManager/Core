<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /**
     * The route group below is used to jam the version number into the URL.
     * This is not the Dingo way of doing things.
     * Eventually we will need to migrate to an accept header
     *
     * https://stackoverflow.com/questions/38664222/dingo-api-how-to-add-version-number-in-url/
     * https://github.com/dingo/api/issues/1221
     */
    $api->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function ($api) {

        $api->get('/', 'ApiController@index');

        $api->group(['prefix' => 'accounts'], function ($api) {
            $api->get('/', 'AccountController@index');
            $api->get('/{id}', 'AccountController@show');
        });

        $api->group(['prefix' => 'roles'], function ($api) {
            $api->get('/', 'RoleController@index');
            $api->get('/{id}', 'RoleController@show');
        });

    });
});