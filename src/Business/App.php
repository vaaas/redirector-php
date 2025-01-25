<?php
namespace Business;

use Business\Router;
use Http\Request;
use Http\Response;
use ServiceLocator;

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
