<?php
namespace Providers;

use Configuration;

final class ConfigurationProvider {
    private const LOCATION = "storage/configuration.php";

    public static function provide(): Configuration {
        /** @var array<string, string> $config */
        $config = require self::LOCATION;
        return new Configuration(
            $config["authUsername"] ?: "",
            $config["authPassword"] ?: ""
        );
    }
}
