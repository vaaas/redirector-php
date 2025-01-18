<?php

use Http\Request;

class AddLinkRequest
{
    public function __construct(
        public readonly string $from,
        public readonly string $to
    ) {
    }

    public static function fromRequest(Request $request)
    {
        $from = $request->post("from");
        $to = $request->post("to");
        if (!$from || !$to) {
            throw new Exception();
        }
        return new AddLinkRequest($from, $to);
    }
}
