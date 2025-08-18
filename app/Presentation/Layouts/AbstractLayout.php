<?php
namespace Presentation\Layouts;

use Presentation\Bufferable;

abstract class AbstractLayout extends Bufferable implements ILayout
{
    public string $contents;

    public function setContents(string $contents): self
    {
        $this->contents = $contents;
        return $this;
    }
}
