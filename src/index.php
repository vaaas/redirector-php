<?php
function plain_text_response(int $status_code, string $text): void {
	http_response_code($status_code);
	echo $text;
	die();
}

function redirect_response(string $target): void {
	http_response_code(302);
	header('Location: ' . $target);
	die();
}

function get_resource(string $url): string {
	$end = strpos($url, '?');
	if ($end === false) $end = strlen($url);
	return substr($url, 1, $end - 1);
}

$url = $_SERVER['REQUEST_URI'];
if ($url === '/')
	plain_text_response(200, 'Hello, world!');

$links = require('links.php');
$resource = get_resource($url);

if (array_key_exists($resource, $links))
	redirect_response($links[$resource]);
else
	plain_text_response(404, 'Not found');
