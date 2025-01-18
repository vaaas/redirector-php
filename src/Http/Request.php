<?php
namespace Http;

class Request
{
    public readonly string $uri;
    public readonly string $resource;
    /** @var array(string, string) $headers */
    public readonly array $headers;
    public readonly string $method;

    public function __construct()
    {
        $this->uri = $_SERVER["REQUEST_URI"];
        $this->resource = $this->get_resource();
        $this->headers = getallheaders() ?: [];
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    public function post(string $k): ?string
    {
        return array_key_exists($k, $_POST) ? $_POST[$k] : null;
    }

    private function get_resource(): string
    {
        $uri = $this->uri;
        $end = strpos($uri, "?");
        if ($end === false) {
            $end = strlen($uri);
        }
        return substr($uri, 1, $end - 1);
    }
}
