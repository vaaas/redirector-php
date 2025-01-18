<?php

class Configuration
{
    private static string $location = "storage/configuration.php";

    public function __construct(
        public readonly string $authUsername,
        public readonly string $authPassword
    ) {
    }

    public static function provider(): self
    {
        $config = require self::$location;
        return new self($config["authUsername"], $config["authPassword"]);
    }
}
