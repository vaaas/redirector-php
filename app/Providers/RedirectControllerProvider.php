<?php
namespace Providers;

use DataAccess\Links;
use Features\Redirect\RedirectController;
use ServiceLocator;

final class RedirectControllerProvider {
    public static function provide(): RedirectController {
        $links = ServiceLocator::get(Links::class);
        return new RedirectController($links);
    }
}
