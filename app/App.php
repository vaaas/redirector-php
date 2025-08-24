<?php

use DependencyInjection\Container;
use Http\IRequest;
use Http\Router;
use Http\Request;
use Http\Response;
use Providers\ConfigurationProvider;
use Providers\FileSystemProvider;
use Providers\LinksProvider;
use Providers\RouterProvider;

final class App
{
    public function __construct(private readonly Router $router) {}

    public function getResponse(IRequest $request): Response {
        return $this->router->route($request);
    }

    public static function start(): void
    {
        $container = self::getContainer();
        $app = $container->get(self::class);
        $response = $app->getResponse(new Request());
        Response::serve($response);
    }

    private static function getContainer(): Container
    {
        $container = new Container();
        return $container
            ->set(Container::class, $container)
            ->register(new FileSystemProvider())
            ->register(new ConfigurationProvider())
            ->register(new LinksProvider())
            ->register(new RouterProvider());
    }
}
