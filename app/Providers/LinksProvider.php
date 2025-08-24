<?php
namespace Providers;

use DataAccess\IFileSystem;
use DataAccess\Links;
use DependencyInjection\Container;
use DependencyInjection\IProvider;

final class LinksProvider implements IProvider {
    private const LOCATION = "links";

    public function register(Container $container): Container
    {
        return $container->provide(Links::class, fn() => $this->get($container));
    }

    private function get(Container $container): Links {
        $fs = $container->get(IFileSystem::class);
        /** @var array<string, string> $entries */
        $entries = unserialize($fs->get(self::LOCATION) ?: "") ?: [];
        return new Links($entries, self::LOCATION);
    }
}
