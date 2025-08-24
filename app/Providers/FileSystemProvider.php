<?php
namespace Providers;

use DataAccess\IFileSystem;
use DataAccess\ScopedFileSystem;
use DependencyInjection\Container;
use DependencyInjection\IProvider;

final class FileSystemProvider implements IProvider
{
    public function register(Container $container): Container
    {
        return $container->provide(IFileSystem::class, fn() => new ScopedFileSystem(getcwd() . '/storage'));
    }
}
