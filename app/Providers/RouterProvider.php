<?php
namespace Providers;

use Http\Router;
use Features\Admin\AdminRoute;
use Features\Redirect\RedirectRoute;

class RouterProvider
{
    public static function provide(): Router
    {
        $router = new Router();
        RedirectRoute::install($router);
        AdminRoute::install($router);
        return $router;
    }
}
