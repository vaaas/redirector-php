<?php
spl_autoload_register(function (string $class) {
    $path = str_replace("\\", "/", $class);
    require $path . ".php";
});

App::start();
