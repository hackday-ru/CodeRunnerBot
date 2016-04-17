<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \Telegram;

class TelegramController extends Controller
{

	public function testBot()
	{
		$response = Telegram::getMe();

		dump([
			'botId' => $response->getId(),
			'firstName' => $response->getFirstName(),
			'username' => $response->getUsername(),
		]);
	}

    public function setWebhook()
    {
		$result = Telegram::setWebhook([
		  'url' => env('HOOK_URL'),
		  'certificate' => base_path(env('SSL_CERT'))
		]);

		dump($result);
    }

    public function handleWebhook()
    {
		$update = Telegram::commandsHandler(true);

		// Commands handler method returns an Update object.
		// So you can further process $update object 
		// to however you want.

		return 'ok';
    }

}
