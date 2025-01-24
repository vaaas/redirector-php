<?php
namespace Presentation;

use Stringable;

abstract class Bufferable implements Stringable
{
    public const template = "";

    public function __toString(): string
    {
        error_log(self::template);
        ob_start();
        require "templates/" . static::template . ".php"; // @phpstan-ignore-line
        return ob_get_clean() ?: "";
    }
}
