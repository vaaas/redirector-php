<?php

namespace Http;

final class MockRequest implements IRequest
{
    /**
     * @param array<string, string> $query
     * @param array<string, string> $headers
     * @param array<string, string> $post
     */
    public function __construct(
        private readonly string $method = '',
        private readonly string $uri = '',
        private readonly array $query = [],
        private readonly array $headers = [],
        private readonly array $post = [],
    ) { }

    public function header(string $k): ?string
    {
        return array_key_exists($k, $this->headers) ? $this->headers[$k] : null;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function post(string $k): ?string
    {
        return array_key_exists($k, $this->post) ? $this->post[$k] : null;
    }

    public function query(string $k): ?string
    {
        return array_key_exists($k, $this->query) ? $this->query[$k] : null;
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
        return $this->uri;
    }
}
