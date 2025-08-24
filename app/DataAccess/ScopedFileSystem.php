<?php
namespace DataAccess;

use Error;

final class ScopedFileSystem implements IFileSystem
{
    public function __construct(private string $scope) { }

    public function require(string $pathname): mixed
    {
        return require($this->getAbsolutePath($pathname));
    }

    public function get(string $pathname): string
    {
        $absolute = $this->getAbsolutePath($pathname);
        $contents = file_get_contents($absolute);
        if ($contents === false)
        {
            throw new Error("failed to read file: " . $absolute);
        }
        return $contents;
    }

    public function set(string $name, string $contents): void
    {
        $pathname = $this->getAbsolutePath($name);
        $result = file_put_contents($pathname, $contents);
        if ($result === false)
        {
            throw new Error("failed to write file " . $pathname);
        }
    }

    private function getAbsolutePath(string $relative): string
    {
        if (str_contains($relative, '..'))
        {
            throw new Error("refusing to commit insecure operation: filename contains ..");
        }
        return $this->scope . '/' . $relative;
    }
}
