<?php
namespace Errors;

use Exception;
use Http\Respondable;
use Http\Response;

final class BadRequest extends Exception implements Respondable
{
    public function response(): Response
    {
        return new Response(400, [], "Bad request");
    }
}
