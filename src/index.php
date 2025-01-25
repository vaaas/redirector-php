<?php

use Business\Router;
use Business\RouterProvider;
use DataAccess\Links;

spl_autoload_register(function (string $class) {
    $path = str_replace("\\", "/", $class);
    require $path . ".php";
});

ServiceLocator::provide(Links::class, Links::provider(...));
ServiceLocator::provide(Configuration::class, Configuration::provider(...));
ServiceLocator::provide(Router::class, RouterProvider::provide(...));

Business\App::start();
