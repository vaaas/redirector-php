<?php
namespace Errors;

use Exception;
use Http\Respondable;
use Http\Response;

final class NotFound extends Exception implements Respondable
{
    public function response(): Response
    {
        return new Response(404, [], "Not found");
    }
}
