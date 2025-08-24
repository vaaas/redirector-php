<?php
namespace DataAccess;

interface IFileSystem
{
    public function require(string $pathname): mixed;
    public function get(string $pathname): string;
    public function set(string $pathname, string $contents): void;
}
