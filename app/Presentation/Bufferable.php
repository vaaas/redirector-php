<?php
namespace Presentation;

use Stringable;

abstract class Bufferable implements Stringable
{
    public function __construct(private readonly string $template) { }

    public function __toString(): string
    {
        ob_start();
        require $this->template;
        return ob_get_clean() ?: "";
    }
}
