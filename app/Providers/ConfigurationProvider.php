<?php
namespace Providers;

use Configuration;
use DataAccess\IFileSystem;
use DependencyInjection\Container;
use DependencyInjection\IProvider;

final class ConfigurationProvider implements IProvider {
    private const LOCATION = "configuration.php";

    public function register(Container $container): Container
    {
        return $container->provide(Configuration::class, fn() => $this->get($container));
    }

    private function get(Container $container): Configuration
    {
        $fs = $container->get(IFileSystem::class);
        /** @var array<string, string> $config */
        $config = $fs->require(self::LOCATION);
        return new Configuration(
            $config["authUsername"] ?: "",
            $config["authPassword"] ?: ""
        );
    }
}
