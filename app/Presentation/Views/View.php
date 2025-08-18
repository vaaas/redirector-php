<?php
namespace Presentation\Views;

use Http\Respondable;
use Http\Response;
use Presentation\Bufferable;
use Presentation\Layouts\ILayout;

abstract class View extends Bufferable implements Respondable
{
    private ?ILayout $layout = null;

    public function __toString(): string
    {
        $contents = parent::__toString();
        return $this->layout
            ? $this->layout->setContents($contents)
            : $contents;
    }

    public function response(int $status = 200): Response
    {
        return new Response($status, ["Content-Type" => "text/html"], $this);
    }

    public function setLayout(ILayout $layout): self
    {
        $this->layout = $layout;
        return $this;
    }
}
