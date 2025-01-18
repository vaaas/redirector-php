<?php
namespace Components;

use Stringable;

class Row implements Stringable
{
    public function __construct(private string $from, private string $to)
    {
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
