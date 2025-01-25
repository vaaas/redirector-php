<?php
namespace Presentation;

use Stringable;

abstract class Bufferable implements Stringable
{
    /** @var string */
    public const template = "";

    public function __toString(): string
    {
        ob_start();
        require "templates/" . static::template . ".php";
        return ob_get_clean() ?: "";
    }
}
