<?php
namespace Business;

use Business\Router;

class RouterProvider
{
    public static function provide(): Router
    {
        return new Router([
            "" => Controllers\Admin::class,
            "*" => Controllers\Redirect::class,
        ]);
    }
}
