<?php
namespace Http;

class Request implements IRequest
{
    public function uri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }

    public function resource(): string
    {
        $uri = $this->uri();
        $end = strpos($uri, "?");
        if ($end === false) {
            $end = strlen($uri);
        }
        return substr($uri, 1, $end - 1);
    }

    public function header(string $k): ?string
    {
        $headers = getallheaders() ?: [];
        return array_key_exists($k, $headers) ? $headers[$k] : null;
    }

    public function method(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function post(string $k): ?string
    {
        return array_key_exists($k, $_POST) ? $_POST[$k] : null;
    }

    public function query(string $k): ?string
    {
        return array_key_exists($k, $_GET) ? $_GET[$k] : null;
    }
}
