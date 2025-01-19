<?php
use Http\Request;
use Http\Response;

class App
{
    public static function start()
    {
        $request = new Request();
        $response = Router::route($request);
        Response::serve($response);
    }
}
