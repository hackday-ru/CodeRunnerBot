<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ReplyKeyboardMarkup;

/**
 * User "/langlist" command
 */
class LangListCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'langlist';
    protected $description = 'Show available languages';
    protected $usage = '/langlist';
    protected $version = '1.0.1';
    /**#@-*/

    private function getLangList()
    {
        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL            => 'http://46.101.237.169:40049/api/lang',
            CURLOPT_RETURNTRANSFER => true,
        ];

        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception('Error receiving data from url');
        }
        curl_close($ch);

        $decode = json_decode($response, true);

        return isset($decode['lang']) ? $decode['lang'] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $text = implode("\n", $this->getLangList());

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
