<?php
namespace Http;

interface IRequest
{
    public function header(string $k): ?string;
    public function method(): string;
    public function post(string $k): ?string;
    public function query(string $k): ?string;
    public function resource(): string;
    public function uri(): string;
}
