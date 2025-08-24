<?php
namespace Providers;

use DependencyInjection\Container;
use DependencyInjection\IProvider;
use Http\Router;
use Features\Admin\AdminRoute;
use Features\Redirect\RedirectRoute;

class RouterProvider implements IProvider
{
    public static function register(Container $container): Container
    {
        return $container->provide(Router::class, fn() => self::get($container));
    }

    private static function get(Container $container): Router
    {
        $router = new Router($container);
        RedirectRoute::install($router);
        AdminRoute::install($router);
        return $router;
    }
}
