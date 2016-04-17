<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Process;

class ApiController extends BaseController
{
    public $lang = [
        'erlang_17',
        'erlang_18',
        'go_1',
        'java_7',
        'java_8',
        'java_9',
        'node_5',
        'php_5',
        'php_7',
        'python_2',
        'python_3',
        'ruby_2'
    ];

    public $hello = [
        'erlang_17' => 'io:fwrite("Hello, world!")',
        'erlang_18' => 'io:fwrite("Hello, world!")',
        'go_1' => "package main\nimport \"fmt\"\nfunc main() {\nfmt.Printf(\"hello, world\")\n}",
        'java_7' => "public static void main(String[] args) {\nSystem.out.println(System.getProperty(\"java.version\"));\n}",
        'java_8' => "public static void main(String[] args) {\nSystem.out.println(System.getProperty(\"java.version\"));\n}",
        'java_9' => "public static void main(String[] args) {\nSystem.out.println(System.getProperty(\"java.version\"));\n}",
        'node_5' => "console.log(1)\nconsole.log(123123)",
        'php_5' => "echo \"1 line\";\necho phpversion();",
        'php_7' => "echo \"1 line\";\necho phpversion();",
        'python_2' => "print 'Goodbye, World'\nprint '123123123'",
        'python_3' => "print('Hello, World')\nprint('Hello, World123123')",
        'ruby_2' => "puts 'Hello, world'\nputs 'Hello, world'"
    ];

    public function compile(Request $request) 
    {
        $lang = $request->input('lang');
        $code = $request->input('code');
        $result = $this->exec_compile($lang, $code);
        return response()->json($result);
    }

    public function exec_compile($lang, $code)
    {
        $session = Session::getId();
        $code = str_replace('\n', "\n", $code);
        $code = str_replace('\r', "\r", $code);
        $execute = function($exec) {
            $process = new Process($exec);
            $process->start();
            while ($process->isRunning()) {}
            return $process->getOutput();
        };
        $error_compile = "";
        switch ($lang) {
            case "php_5":
                $name = '/home/gregory/compile/php_5'.$session.'.php';
                $code = "<?php\n".$code;
                file_put_contents($name, $code);
                $name_container = '/compile/php_5'.$session.'.php';
                $exec = 'docker exec php_5 php '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "php_7":
                $name = '/home/gregory/compile/php_7'.$session.'.php';
                $code = "<?php\n".$code;
                file_put_contents($name, $code);
                $name_container = '/compile/php_7'.$session.'.php';
                $exec = 'docker exec php_7 php '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "erlang_17":
                $code .= ", init:stop().";
                $exec = 'docker exec erlang_17 erl -noshell -eval \''.$code.'\' 2>&1';
                $result = $execute($exec);
                break;
            case "erlang_18":
                $code .= ", init:stop().";
                $exec = 'docker exec erlang_18 erl -noshell -eval \''.$code.'\' 2>&1';
                $result = $execute($exec);
                break;
            case "python_2":
                $name = '/home/gregory/compile/python_2'.$session.'.py';
                $code = "#!/usr/bin/env python\n".$code;
                file_put_contents($name, $code);
                $name_container = '/compile/python_2'.$session.'.py';
                $exec = 'docker exec python_2 python '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "python_3":
                $name = '/home/gregory/compile/python_3'.$session.'.py';
                $code = "#!/usr/bin/env python\n".$code;
                file_put_contents($name, $code);
                $name_container = '/compile/python_3'.$session.'.py';
                $exec = 'docker exec python_3 python '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "node_5":
                $name = '/home/gregory/compile/node_5'.$session.'.js';
                file_put_contents($name, $code);
                $name_container = '/compile/node_5'.$session.'.js';
                $exec = 'docker exec node_5 node '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "ruby_2":
                $name = '/home/gregory/compile/ruby_2'.$session.'.rb';
                file_put_contents($name, $code);
                $name_container = '/compile/ruby_2'.$session.'.rb';
                $exec = 'docker exec ruby_2 ruby '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "go_1":
                $name = '/home/gregory/compile/go_1'.$session.'.go';
                file_put_contents($name, $code);
                $name_container = '/compile/go_1'.$session.'.go';
                $exec = 'docker exec go_1 go run '.$name_container.' 2>&1';
                $result = $execute($exec);
                break;
            case "java_7":
                $c_name = 'Java7'.$session;
                $name = '/home/gregory/compile/'.$c_name.'.java';
                $code = "
                class $c_name {
$code
}
                ";
                file_put_contents($name, $code);
                $name_container = '/compile/'.$c_name.'.java';
                $exec = 'docker exec java_7 javac '.$name_container.' 2>&1';
                $error_compile = $execute($exec);
                $exec = 'docker exec java_7 /bin/bash -c "cd /compile/ && java '.$c_name.'"';
                $result = $execute($exec);
                break;
            case "java_8":
                $c_name = 'Java8'.$session;
                $name = '/home/gregory/compile/'.$c_name.'.java';
                $code = "
                class $c_name {
$code
}
                ";
                file_put_contents($name, $code);
                $name_container = '/compile/'.$c_name.'.java';
                $exec = 'docker exec java_8 javac '.$name_container.' 2>&1';
                $error_compile = $execute($exec);
                $exec = 'docker exec java_8 /bin/bash -c "cd /compile/ && java '.$c_name.'"';
                $result = $execute($exec);
                break;
            case "java_9":
                $c_name = 'Java9'.$session;
                $name = '/home/gregory/compile/'.$c_name.'.java';
                $code = "
                class $c_name {
$code
}
                ";
                file_put_contents($name, $code);
                $name_container = '/compile/'.$c_name.'.java';
                $exec = 'docker exec java_9 javac '.$name_container.' 2>&1';
                $error_compile = $execute($exec);
                $exec = 'docker exec java_9 /bin/bash -c "cd /compile/ && java '.$c_name.'"';
                $result = $execute($exec);
                break;
            default:
                break;
        }
        $result = [
            'result' => $result
        ];
        if ($error_compile) {
            $result['error_compile'] = $error_compile;
        }
        return $result;
    }
    
    public function lang()
    {
        return response()->json(['lang' => $this->lang]);
    }
    
    public function hello(Request $request)
    {
        $lang = $request->input('lang');

        if (!empty($this->hello[$lang]))
            return $this->hello[$lang];
        else
            return $this->hello;
    }

    public function slack(Request $request)
    {
        try {
            $input = Input::all();
            $code_text = $input['text'];
            $code_text = str_replace("compile ", "", $code_text);
            $code = explode("\n\n", $code_text);
            $message = $this->exec_compile($code[0], $code[1]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $ch = curl_init( "https://hooks.slack.com/services/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" );
        $data = [
            "channel" => "#coderunner",
            "username" => "coderunner",
            "text" => json_encode($message),
            "icon_emoji" => ":ghost:"
        ];
        $payload = json_encode( $data );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function help()
    {
        $ch = curl_init( "https://hooks.slack.com/services/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" );
        $text = "";
        foreach ($this->lang as $lang) {
            $text .= $lang."\n";
        }
        $text .= "
Example hello: hello php_5

Example run:

\"compile php_5

echo 1+3;\"
        ";
        $data = [
            "channel" => "#coderunner",
            "username" => "coderunner",
            "text" => $text,
            "icon_emoji" => ":ghost:"
        ];
        $payload = json_encode( $data );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function helloSlack()
    {
        $input = Input::all();
        $code_text = $input['text'];
        $code_text = str_replace("hello ", "", $code_text);
        $hello = $this->hello[$code_text];
        $hello = "compile $code_text

".$hello;

        $ch = curl_init( "https://hooks.slack.com/services/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" );
        $data = [
            "channel" => "#coderunner",
            "username" => "coderunner",
            "text" => $hello,
            "icon_emoji" => ":ghost:"
        ];
        $payload = json_encode( $data );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
