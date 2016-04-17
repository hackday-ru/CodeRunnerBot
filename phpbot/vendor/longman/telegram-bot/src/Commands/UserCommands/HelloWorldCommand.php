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
        $lang = $message->getText(true);

        if (!empty($lang)) {
            $hello_world = $this->getHelloWorld($lang);
            $text = $hello_world . "\n\n" . $this->evalCode($lang, $hello_world);
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
