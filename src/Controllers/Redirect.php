<?php
namespace Controllers;

use Errors\NotFound;
use Http\Request;
use Http\Response;
use Links;

class Redirect
{
    public static function handle(Request $request): Response
    {
        $links = Links::load();
        $target = $links->get($request->resource);
        if (!$target) {
            throw new NotFound();
        }
        return Response::redirect($target);
    }
}
