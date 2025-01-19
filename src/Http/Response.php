<?php
namespace Http;

class Response
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        public readonly int $status,
        public readonly array $headers,
        public readonly string $body
    ) {
    }

    public static function redirect(string $to): Response
    {
        return new Response(302, ["Location" => $to], "");
    }

    public static function serve(Response $response): void
    {
        http_response_code($response->status);
        foreach ($response->headers as $k => $v) {
            header($k . ": " . $v);
        }
        echo $response->body;
    }
}
