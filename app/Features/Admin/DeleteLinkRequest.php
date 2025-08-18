<?php
namespace Features\Admin;

use Exception;
use Http\IRequest;

/** @immutable */
final class DeleteLinkRequest
{
    public function __construct(public readonly string $entry) { }

    public static function fromRequest(IRequest $request): self
    {
        $entry = $request->post("entry");
        if (!$entry) {
            throw new Exception();
        }
        return new self(trim($entry));
    }
}
