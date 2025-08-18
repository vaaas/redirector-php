<?php
namespace Features\Admin\Presentation\DefaultLayout;

use Presentation\Bufferable;
use Presentation\ILayout;

final class DefaultLayout extends Bufferable implements ILayout
{
    public string $contents;

    public function __construct(public readonly string $title) {
        parent::__construct(__DIR__ . '/template.php');
    }

    public function setContents(string $contents): self {
        $this->contents = $contents;
        return $this;
    }
}
