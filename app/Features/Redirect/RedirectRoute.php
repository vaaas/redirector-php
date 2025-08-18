<?php
namespace Features\Redirect;

use Http\Route;
use Http\Router;

final class RedirectRoute implements Route {
    public static function install(Router $router): Router
    {
        return $router->add('*', RedirectController::class);
    }
}
