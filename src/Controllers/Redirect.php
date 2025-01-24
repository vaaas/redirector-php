<?php
namespace Controllers;

use DataAccess\Links;
use Errors\NotFound;
use Http\IRequest;
use Http\Response;
use ServiceLocator;

/** @immutable */
final class Redirect
{
    private readonly Links $links;

    public function __construct()
    {
        $this->links = ServiceLocator::get(Links::class);
    }

    public function handle(IRequest $request): Response
    {
        $target = $this->links->get($request->resource());
        if (!$target) {
            throw new NotFound();
        }
        return Response::redirect($target);
    }
}
