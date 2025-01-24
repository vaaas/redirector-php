<?php
namespace Presentation\Components;

use Presentation\Bufferable;

/** @immutable */
final class Row extends Bufferable
{
    public const template = "components/row";

    public function __construct(
        public readonly string $from,
        public readonly string $to
    ) {}
}
