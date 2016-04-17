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

Route::get('test', [
    'as' => 'bot.test',
    'uses' => 'TelegramController@testBot'
]);

Route::get('register-webhook', [
    'as' => 'webhook.register',
    'uses' => 'TelegramController@setWebhook'
]);

Route::post(env('TELEGRAM_BOT_TOKEN') . '/webhook', [
    'as' => 'webhook.handle',
    'uses' => 'TelegramController@handleWebhook'
]);
