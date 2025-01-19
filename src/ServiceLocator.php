<?php

class ServiceLocator
{
    /** @var array<class-string, object> $instances */
    private static array $instances = [];

    /** @var array<class-string, callable(): object> $providers */
    private static array $providers = [];

    /**
     * @template T of object
     * @param class-string<T> $request
     * @return T
     */
    public static function get(string $request): object
    {
        if (!array_key_exists($request, self::$instances)) {
            self::instantiate($request);
        }
        /** @var T */
        return self::$instances[$request];
    }

    /**
     * @template T of object
     * @param class-string<T> $request
     * @param callable(): T $provider
     * @return class-string<self>
     */
    public static function provide(string $request, callable $provider): string
    {
        self::$providers[$request] = $provider;
        return self::class;
    }

    /**
     * @template T of object
     * @param class-string<T> $request
     */
    private static function instantiate(string $request): void
    {
        $instance = array_key_exists($request, self::$providers)
            ? self::$providers[$request]()
            : new $request();
        self::$instances[$request] = $instance;
    }
}
