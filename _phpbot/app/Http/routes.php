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

// $app->get('/', function () use ($app) {
// 	echo 'hello there';
// });

$app->get('register-webhook', function () {
	try {
	    // Create Telegram API object
	    $telegram = new Longman\TelegramBot\Telegram(env('API_KEY'), env('BOT_NAME'));

	    // Set webhook
	$result = $telegram->setWebHook(env('HOOK_URL'), base_path(env('SSL_CERT')));
	    if ($result->isOk()) {
		echo $result->getDescription();
	    }
	} catch (Longman\TelegramBot\Exception\TelegramException $e) {
	    echo $e;
	}
});

$app->post(env('API_KEY') . '/webhook', function () {
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram(env('API_KEY'), env('BOT_NAME'));
    $telegram->addCommandsPath(base_path(env('COMMAND_PATH')));

    // Handle telegram webhook request
	$telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    // echo $e;
}
});

