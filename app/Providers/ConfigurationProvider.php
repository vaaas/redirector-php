<?php
namespace Providers;

use Configuration;
use DependencyInjection\Container;
use DependencyInjection\IProvider;

final class ConfigurationProvider implements IProvider {
    private const LOCATION = "storage/configuration.php";

    public static function register(Container $container): Container
    {
        return $container->provide(Configuration::class, self::get(...));
    }

    private static function get(): Configuration
    {
        /** @var array<string, string> $config */
        $config = require self::LOCATION;
        return new Configuration(
            $config["authUsername"] ?: "",
            $config["authPassword"] ?: ""
        );
    }
}
