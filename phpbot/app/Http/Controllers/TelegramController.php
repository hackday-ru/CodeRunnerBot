<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \Telegram;

class TelegramController extends Controller
{

    public function setWebhook()
    {
		Telegram::setWebhook([
		  'url' => env('HOOK_URL'),
		  'certificate' => base_path(env('SSL_CERT'))
		]);
    }

    public function handleWebhook()
    {

    }
}
