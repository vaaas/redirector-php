<?php
namespace Http;

use DependencyInjection\Container;
use Http\Errors\MethodNotAllowed;
use Http\Errors\NotFound;
use Http\IRequest;
use Http\Respondable;
use Http\Response;
use Throwable;
use TypeError;

final class Router
{
    /** @var array<string, class-string> $routes */
    private array $routes;

    public function __construct(private Container $container)
    {
        $this->routes = [];
    }

    /** @param class-string $value */
    public function add(string $key, string $value): self {
        $this->routes[$key] = $value;
        return $this;
    }

    public function route(IRequest $request): Response
    {
        try {
            return $this->tryToRoute($request);
        } catch (Throwable $error) {
            return $this->error_handler($error);
        }
    }

    private function tryToRoute(IRequest $request): Response
    {
        $resource = $request->resource();
        $class = array_key_exists($resource, $this->routes)
            ? $this->routes[$resource]
            : $this->routes['*'];
        if (!$class) {
            throw new NotFound();
        }
        $instance = $this->container->get($class);
        $method = strtolower($request->method());
        if (!method_exists($instance, $method)) {
            throw new MethodNotAllowed();
        }
        $result = $instance->$method($request);
        if (!($result instanceof Response)) {
            throw new TypeError();
        }
        return $result;
    }

    private function error_handler(Throwable $error): Response
    {
        if ($error instanceof Respondable) {
            return $error->response();
        } else {
            error_log(
                $error->getMessage() . " | " . $error->getTraceAsString()
            );
            return new Response(500, [], "Internal server error");
        }
    }
}
