<?
$response['request'] = $_REQUEST;

$context = stream_context_create(
	Array(
		'http' => Array(
			'method' => "POST",
			'content' => http_build_query(
				Array(
					'lang' => $_REQUEST['lang'],
					'code' => $_REQUEST['request']
				)
			)
		)
	)
);

$response['response'] = json_decode(file_get_contents(
	'http://46.101.237.169:40049/api/compile',
	false,
	$context
),true);

$response['status'] = 'good';

echo json_encode($response);