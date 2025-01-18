<?php

use Http\Request;
use Http\Response;

class Router
{
    public static function route(Request $request): Response
    {
        try {
            return match ($request->uri) {
                "/" => Controllers\Admin::handle($request),
                default => Controllers\Redirect::handle($request),
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
