<?php

spl_autoload_register(function (string $class) {
    $path = str_replace("\\", "/", $class);
    require "app/" . $path . ".php";
});

App::start();
