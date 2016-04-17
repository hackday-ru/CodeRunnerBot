<?
$context = stream_context_create(
	Array(
		'http' => Array(
			'method' => "GET",
			'timeout' => 10
		)
	)
);

$langs = json_decode(file_get_contents('http://46.101.237.169:40049/api/lang', false, $context),true);
$arResult['langs'] = $langs['lang'];

$arResult['templates'] = json_decode(file_get_contents('http://46.101.237.169:40049/api/hello', false, $context),true);

$arResult['COMPONENT_DIRECTORY'] = '/local/components/codeRunner/request.send/';

require_once($_SERVER["DOCUMENT_ROOT"]."/local/components/codeRunner/request.send/templates/.default/template.php");