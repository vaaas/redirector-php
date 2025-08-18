<?php
namespace Presentation\Views;

use DataAccess\Links;
use ServiceLocator;

final class AdminPanel extends View
{
    public const template = "views/admin-panel";

    /** @var array<string, string> $links */
    public readonly array $links;

    public function __construct()
    {
        $this->links = ServiceLocator::get(Links::class)->all();
    }
}
