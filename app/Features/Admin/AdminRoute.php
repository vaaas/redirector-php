<?php
namespace Features\Admin;

use Http\Route;
use Http\Router;

final class AdminRoute implements Route{
    public static function install(Router $router): Router
    {
        return $router->add('', AdminController::class);
    }
}
