<?php
namespace Features\Admin\Presentation\AddEntry;

use Presentation\Bufferable;

/** @immutable */
final class AddEntry extends Bufferable
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/template.php');
    }
}
