<?php

use Http\IRequest;
use Http\Respondable;
use Http\Response;

class Router
{
    public static function route(IRequest $request): Response
    {
        try {
            return match ($request->resource()) {
                "" => ServiceLocator::get(Controllers\Admin::class)->handle(
                    $request
                ),
                default => ServiceLocator::get(
                    Controllers\Redirect::class
                )->handle($request),
            };
        } catch (Throwable $error) {
            if ($error instanceof Respondable) {
                return $error->response();
            } else {
                return new Response(500, [], $error->getMessage());
            }
        }
    }
}
