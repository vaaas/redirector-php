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

function strslice(string $str, int $start, int $end): string {
	return substr($str, $start, $end - $start);
}

$links = include('links.php');

if (!$links) plain_text_response(404, 'Not found');

$url = $_SERVER['REQUEST_URI'];

/** @var int | null */
$end = strpos($url, '?');
if ($end === false) $end = strlen($url);

$url = strslice($url, 1, $end);

if (array_key_exists($url, $links)) redirect_response($links[$url]);
else plain_text_response(404, 'Not found');
