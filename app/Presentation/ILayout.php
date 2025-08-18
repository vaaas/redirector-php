<?php
namespace Presentation;

use Stringable;

interface ILayout extends Stringable
{
    public function setContents(string $contents): self;
}
