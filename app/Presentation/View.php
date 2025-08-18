<?php
namespace Presentation;

use Http\Respondable;
use Http\Response;

abstract class View extends Bufferable implements Respondable
{
    private ?ILayout $layout = null;
    private const MIMETYPE = 'text/html';

    public function __toString(): string
    {
        $contents = parent::__toString();
        return $this->layout
            ? $this->layout->setContents($contents)->__toString()
            : $contents;
    }

    public function response(int $status = 200): Response
    {
        return new Response($status, ["Content-Type" => self::MIMETYPE], $this);
    }

    public function setLayout(ILayout $layout): self
    {
        $this->layout = $layout;
        return $this;
    }
}
