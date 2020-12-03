<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('index');
});

$router->get('key', function () {
    return Illuminate\Support\Str::random(32);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'files'], function () use ($router) {
        $router->get('download/{id}', ['uses' => 'FileManagerController@download']);
        $router->get('total', ['uses' => 'FileManagerController@total']);
    });

    $router->get('files', ['uses' => 'FileManagerController@index']);
    $router->post('files', ['uses' => 'FileManagerController@store']);
    $router->get('files/{id}', ['uses' => 'FileManagerController@show']);
    $router->delete('files/{id}', ['uses' => 'FileManagerController@destroy']);
});
