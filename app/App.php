<?php
use Http\Router;
use Http\Request;
use Http\Response;

final class App
{
    public static function start(): void
    {
        $request = new Request();
        $router = ServiceLocator::get(Router::class);
        $response = $router->route($request);
        Response::serve($response);
    }
}
