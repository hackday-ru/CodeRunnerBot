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
 * User "/eval" command
 */
class EvalCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'eval';
    protected $description = 'Evaluate your code';
    protected $usage = '/eval <language>:<code>';
    protected $version = '1.0.1';
    protected $public = true;
    /**#@-*/

    private function evalCode($language, $code)
    {
        $ch = curl_init();
        $curlConfig = [
            CURLOPT_URL            => 'http://46.101.237.169:40049/api/compile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => 2,
            CURLOPT_POSTFIELDS     => http_build_query(['lang' => $language, 'code' => $code])
        ];

        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception('Error receiving data from url');
        }
        curl_close($ch);

        $decode = json_decode($response, true);

        return isset($decode['result']) ? $decode['result'] : '';
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();

        $chat_id = $message->getChat()->getId();
        $message_id = $message->getMessageId();
        $text = $message->getText(true);

        if (preg_match('/(?<language>[^:]+):(?<code>.+)/m', $text, $parts)) {
            $text = $this->evalCode($parts['language'], $parts['code']);
        } else {
            $text = 'You must use following format: /eval <language>:<code>';
        }

        $data = [
            'chat_id'             => $chat_id,
            'reply_to_message_id' => $message_id,
            'text'                => $text,
        ];

        return Request::sendMessage($data);
    }
}
