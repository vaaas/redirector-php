<?php
namespace DependencyInjection;

use Closure;
use Error;
use ReflectionClass;
use ReflectionFunction;
use ReflectionNamedType;
use ReflectionParameter;

final class Container
{
    /** @var array<class-string, object> $instances */
    private array $instances = [];

    /** @var array<class-string, callable(): object> $providers */
    private array $providers = [];

    /**
     * @template T of object
     * @param class-string<T> $request
     * @return T
     */
    public function get(string $request): object
    {
        return $this->getFromInstances($request)
            ?: $this->getFromProviders($request)
            ?: $this->getFromReflection($request);
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @param T $instance
     * @return self
     */
    public function set(string $class, object $instance): self
    {
       $this->instances[$class] = $instance;
       return $this;
    }

    /**
     * @template T of object
     * @param class-string<T> $request
     * @param callable(): T $provider
     * @return self
     */
    public function provide(string $request, callable $provider): self
    {
        $this->providers[$request] = $provider;
        return $this;
    }

    public function register(IProvider $provider): self
    {
        return $provider->register($this);
    }

    public function call(Closure $f): mixed
    {
        $reflection = new ReflectionFunction($f);
        $params = array_map($this->getFromParameter(...), $reflection->getParameters());
        return $f(...$params);
    }

    /**
     * @template T of object
     * @param class-string<T> $x
     * @return ?T
     */
    private function getFromInstances(string $x): ?object
    {
        if (array_key_exists($x, $this->instances))
        {
            /** @var T $instance */
            $instance = $this->instances[$x];
            return $instance;
        }
        else
        {
            return null;
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $x
     * @return ?T
     */
    private function getFromProviders(string $x): ?object
    {
        if (!array_key_exists($x, $this->providers))
        {
            return null;
        }
        $provider = $this->providers[$x];
        /** @var T $instance */
        $instance = $provider();
        $this->set($x, $instance);
        return $instance;
    }


    /**
     * @template T of object
     * @param class-string<T> $x
     * @return T
     */
    private function getFromReflection(string $x)
    {
        $reflection = (new ReflectionClass($x))->getConstructor();
        if (!$reflection)
        {
            $instance = new $x();
            $this->set($x, $instance);
            return $instance;
        }
        $params = array_map($this->getFromParameter(...), $reflection->getParameters());
        $instance = new $x(...$params);
        $this->set($x, $instance);
        return $instance;
    }

    private function getFromParameter(ReflectionParameter $x): object
    {
        $type = $x->getType();
        if (!$type)
        {
            throw new Error("cannot instantiate null value");
        }
        if (!($type instanceof ReflectionNamedType))
        {
            throw new Error("can only instantiate classes, got " . $type->__toString());
        }
        if ($type->isBuiltin())
        {
            throw new Error("cannot instantiate builtins, got " . $type->__toString());
        }
        /** @var class-string $class*/
        $class = $type->getName();
        return $this->get($class);
    }
}
