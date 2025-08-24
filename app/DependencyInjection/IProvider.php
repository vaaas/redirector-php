<?php
namespace DependencyInjection;

interface IProvider {
    public static function register(Container $container): Container;
}
