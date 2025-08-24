<?php
namespace DependencyInjection;

interface IProvider {
    public function register(Container $container): Container;
}
