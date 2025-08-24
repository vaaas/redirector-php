<?php
namespace Providers;

use DataAccess\Links;
use DependencyInjection\Container;
use DependencyInjection\IProvider;

final class LinksProvider implements IProvider {
    private const LOCATION = "storage/links";

    public static function register(Container $container): Container
    {
        return $container->provide(Links::class, self::get(...));
    }

    private static function get(): Links {
        /** @var array<string, string> $entries */
        $entries = unserialize(file_get_contents(self::LOCATION) ?: "") ?: [];
        return new Links($entries, self::LOCATION);
    }
}
