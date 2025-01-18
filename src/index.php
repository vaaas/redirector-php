<?php
spl_autoload_register(function (string $class) {
    $path = str_replace("\\", "/", $class);
    require $path . ".php";
});

ServiceLocator::provide(Links::class, Links::provider(...));
ServiceLocator::provide(Configuration::class, Configuration::provider(...));

App::start();
