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
/**
 * User "/helloworld" command
 */
class HelloWorldCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'helloworld';
    protected $description = 'Returns simple code for specified language';
    protected $usage = '/helloworld <language>';
    protected $version = '1.0.1';
    protected $public = true;
    /**#@-*/

    private function getHelloWorld($language)
    {
        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL            => 'http://46.101.237.169:40049/api/hello?lang=' . $language,
            CURLOPT_RETURNTRANSFER => true,
        ];

        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception('Error receiving data from url');
        }
        curl_close($ch);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $text = $message->getText(true);

        if (!empty($text)) {
            $text = $this->getHelloWorld($text);
        } else {
            $text = 'You must use following format: /helloworld <language>';
        }

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
