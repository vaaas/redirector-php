<?php
namespace Errors;

use Exception;
use Http\Respondable;
use Http\Response;

final class MethodNotAllowed extends Exception implements Respondable
{
    public function response(): Response
    {
        return new Response(405, [], "Method not allowed");
    }
}
