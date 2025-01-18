<?php

use Errors\Unauthorized;
use Http\Request;

class BasicAuth
{
    public static function authorise(Request $request)
    {
        $authorization = $request->headers["Authorization"];
        if (!$authorization) {
            throw new Unauthorized();
        }
        if (!str_starts_with($authorization, "Basic ")) {
            throw new Unauthorized();
        }
        $encoded = substr($authorization, 6);
        if (!$encoded) {
            throw new Unauthorized();
        }
        $decoded = base64_decode($encoded);
        $parts = explode(":", $decoded);
        if (count($parts) !== 2) {
            throw new Unauthorized();
        }
        [$username, $password] = $parts;
        if ($username !== "admin" || $password !== "password") {
            throw new Unauthorized();
        }
    }
}
