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
    return view('welcome');
});

Route::post('api/compile', [
    'as'   => 'api.compile',
    'uses' => 'ApiController@compile'
]);

Route::get('api/lang', [
    'as'   => 'api.lang',
    'uses' => 'ApiController@lang'
]);

Route::get('api/hello', [
    'as'   => 'api.hello',
    'uses' => 'ApiController@hello'
]);

Route::post('api/slack', [
    'as'   => 'api.slack',
    'uses' => 'ApiController@slack'
]);

Route::post('api/help', [
    'as'   => 'api.help',
    'uses' => 'ApiController@help'
]);

Route::post('api/hello', [
    'as'   => 'api.hello',
    'uses' => 'ApiController@helloSlack'
]);