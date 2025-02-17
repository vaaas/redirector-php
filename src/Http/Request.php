<?php
namespace Http;

final class Request implements IRequest
{
    public function header(string $k): ?string
    {
        $headers = getallheaders() ?: [];
        /** @var ?string */
        return array_key_exists($k, $headers) ? $headers[$k] : null;
    }

    public function method(): string
    {
        /** @var string */
        return $_SERVER["REQUEST_METHOD"];
    }

    public function post(string $k): ?string
    {
        /** @var ?string */
        return array_key_exists($k, $_POST) ? $_POST[$k] : null;
    }

    public function query(string $k): ?string
    {
        /** @var ?string */
        return array_key_exists($k, $_GET) ? $_GET[$k] : null;
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

    public function uri(): string
    {
        /** @var string */
        return $_SERVER["REQUEST_URI"];
    }
}
