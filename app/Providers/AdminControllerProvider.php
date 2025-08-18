<?php
namespace Providers;

use DataAccess\Links;
use Features\Admin\AdminController;
use Http\BasicAuth;
use ServiceLocator;

final class AdminControllerProvider {
    public static function provide(): AdminController {
        $auth = ServiceLocator::get(BasicAuth::class);
        $links = ServiceLocator::get(Links::class);
        return new AdminController($auth, $links);
    }
}
