<?php

use DependencyInjection\Container;
use Http\Router;
use Http\Request;
use Http\Response;
use Providers\ConfigurationProvider;
use Providers\LinksProvider;
use Providers\RouterProvider;

final class App
{
    public static function start(): void
    {
        self::getContainer()->call(function (Request $request, Router $router)
        {
            Response::serve($router->route($request));
        });
    }

    public static function getContainer(): Container
    {
        $container = new Container();
        $container->set(Container::class, $container);
        ConfigurationProvider::register($container);
        LinksProvider::register($container);
        RouterProvider::register($container);
        return $container;
    }
}
