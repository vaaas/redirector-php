<?php
namespace Features\Admin\Presentation\Row;

use Presentation\Bufferable;

/** @immutable */
final class Row extends Bufferable
{
    public function __construct(
        public readonly string $from,
        public readonly string $to
    ) {
        parent::__construct(__DIR__ . '/template.php');
    }
}
