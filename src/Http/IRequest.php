<?php
namespace Http;

interface IRequest
{
    public function uri(): string;

    public function resource(): string;

    /** @var array(string, string) $headers */
    public function header(string $k): ?string;

    public function method(): string;

    public function post(string $k): ?string;
}
