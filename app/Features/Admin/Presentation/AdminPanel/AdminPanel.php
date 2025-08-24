<?php
namespace Features\Admin\Presentation\AdminPanel;

use DataAccess\Links;
use Presentation\View;

final class AdminPanel extends View
{
    /** @var array<string, string> $links */
    public readonly array $links;

    public function __construct(Links $links)
    {
        parent::__construct(__DIR__ . '/template.php');
        $this->links = $links->all();
    }
}
