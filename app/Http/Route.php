<?php
namespace Http;

interface Route {
    public static function install(Router $router): Router;
}
