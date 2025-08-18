<?php

/** @immutable */
final class Configuration
{
    public function __construct(
        public readonly string $authUsername,
        public readonly string $authPassword
    ) { }
}
