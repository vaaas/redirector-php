<?php

/** @immutable */
final class Configuration
{
    private const LOCATION = "storage/configuration.php";

    public function __construct(
        public readonly string $authUsername,
        public readonly string $authPassword
    ) {
    }

    public static function provider(): self
    {
        /** @var array<string, string> $config */
        $config = require self::LOCATION;
        return new self(
            $config["authUsername"] ?: "",
            $config["authPassword"] ?: ""
        );
    }
}
