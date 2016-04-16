<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Telegram\Bot\Api;

class Telegram extends Controller
{
	private $telegram;

	public function __construct(Api $telegram)
	{
		$this->telegram = $telegram;
	}

    public function setWebhook()
    {
		$this->telegram->setWebhook([
		  'url' => env('HOOK_URL'),
		  'certificate' => base_path(env('SSL_CERT'))
		]);
    }

    public function handleWebhook()
    {

    }
}
