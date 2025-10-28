<?php
namespace Providers;

use DataAccess\IFileSystem;
use DataAccess\Links;
use DependencyInjection\Container;
use DependencyInjection\IProvider;
use Error;

final class LinksProvider implements IProvider {
    private const LOCATION = "links";

    public function register(Container $container): Container
    {
        return $container->provide(Links::class, fn() => $this->get($container));
    }

    private function get(Container $container): Links {
        $fs = $container->get(IFileSystem::class);
        $contents = "";
        try {
            $contents = $fs->get(self::LOCATION) ?: "";
        } catch (Error $e) {
            error_log("Failed to read links. Most likely this is because links are empty. Proceeding with empty links.");
        }
        /** @var array<string, string> $entries */
        $entries = unserialize($contents) ?: [];
        return new Links($entries, self::LOCATION, $fs);
    }
}
