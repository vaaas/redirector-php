<?php

use Errors\Unauthorized;
use Http\IRequest;

class BasicAuth
{
    private readonly string $expected;

    public function __construct()
    {
        $config = ServiceLocator::get(Configuration::class);
        $this->expected = base64_encode(
            "{$config->authUsername}:{$config->authPassword}"
        );
    }

    public function authorise(IRequest $request)
    {
        $authorization = $request->header("Authorization");
        if (!$authorization) {
            throw new Unauthorized();
        }
        if (!str_starts_with($authorization, "Basic ")) {
            throw new Unauthorized();
        }
        $encoded = substr($authorization, 6);
        if ($encoded !== $this->expected) {
            throw new Unauthorized();
        }
    }
}
