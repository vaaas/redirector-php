<?php
use DataAccess\Links;
use Features\Admin\AdminController;
use Features\Redirect\RedirectController;
use Http\Router;
use Providers\AdminControllerProvider;
use Providers\ConfigurationProvider;
use Providers\LinksProvider;
use Providers\RedirectControllerProvider;
use Providers\RouterProvider;

spl_autoload_register(function (string $class) {
    $path = str_replace("\\", "/", $class);
    require "app/" . $path . ".php";
});

ServiceLocator::provide(AdminController::class, AdminControllerProvider::provide(...));
ServiceLocator::provide(Configuration::class, ConfigurationProvider::provide(...));
ServiceLocator::provide(Links::class, LinksProvider::provide(...));
ServiceLocator::provide(RedirectController::class, RedirectControllerProvider::provide(...));
ServiceLocator::provide(Router::class, RouterProvider::provide(...));

App::start();
