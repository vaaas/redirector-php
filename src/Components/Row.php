<?php
namespace Components;

use Stringable;

/** @immutable */
final class Row implements Stringable
{
    public function __construct(
        private readonly string $from,
        private readonly string $to
    ) {
    }

    public function __toString(): string
    {
        $from = htmlspecialchars($this->from);
        $to = htmlspecialchars($this->to);
        return <<<EOF
<tr>
    <td>{$from}</td>
    <td><a href="{$to}">{$to}</a></td>
    <td>
        <button form="delete-{$from}" class="delete" name="entry" value="{$from}" type="submit">
            Delete
        </button>
    </td>
</tr>
EOF;
    }
}
