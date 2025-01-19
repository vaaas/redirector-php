<?php
namespace Views;

use Links;
use ServiceLocator;

class AdminPanel extends View
{
    /** @var array<string, string> $links */
    public readonly array $links;

    public function __construct()
    {
        $this->links = ServiceLocator::get(Links::class)->entries;
        $this->view = "admin-panel";
    }
}
