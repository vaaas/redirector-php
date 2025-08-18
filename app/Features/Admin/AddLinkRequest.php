<?php
namespace Features\Admin;

use Exception;
use Http\IRequest;

/** @immutable */
final class AddLinkRequest
{
    public function __construct(
        public readonly string $from,
        public readonly string $to
    ) { }

    public static function fromRequest(IRequest $request): self
    {
        $from = $request->post("from");
        $to = $request->post("to");
        if (!$from || !$to) {
            throw new Exception();
        }
        return new self(trim($from), trim($to));
    }
}
