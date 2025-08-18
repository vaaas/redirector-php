<?php
namespace Features\Redirect;

use DataAccess\Links;
use Http\Errors\NotFound;
use Http\IRequest;
use Http\Response;

/** @immutable */
final class RedirectController
{
    public function __construct(
        private readonly Links $links,
    ) { }

    public function get(IRequest $request): Response
    {
        $target = $this->links->get($request->resource());
        if (!$target) {
            throw new NotFound();
        }
        return Response::redirect($target);
    }
}
