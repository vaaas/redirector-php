<?php
namespace Controllers;

use Errors\NotFound;
use Http\Request;
use Http\Response;
use Links;
use ServiceLocator;

class Redirect
{
    private readonly Links $links;
    public function __construct()
    {
        $this->links = ServiceLocator::get(Links::class);
    }

    public function handle(Request $request): Response
    {
        $target = $this->links->get($request->resource);
        if (!$target) {
            throw new NotFound();
        }
        return Response::redirect($target);
    }
}
