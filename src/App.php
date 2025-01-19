<?php
use Http\Request;
use Http\Response;

final class App
{
    public static function start(): void
    {
        $request = new Request();
        $response = Router::route($request);
        Response::serve($response);
    }
}
