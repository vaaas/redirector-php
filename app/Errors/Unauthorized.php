<?php
namespace Errors;

use Exception;
use Http\Respondable;
use Http\Response;

final class Unauthorized extends Exception implements Respondable
{
    public function response(): Response
    {
        return new Response(
            401,
            ["WWW-Authenticate" => "Basic"],
            "Unauthorized"
        );
    }
}
