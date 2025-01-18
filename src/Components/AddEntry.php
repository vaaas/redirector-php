<?php
namespace Components;

use Stringable;

class AddEntry implements Stringable
{
    public function __toString(): string
    {
        return <<<EOF
<tr>
    <td>
        <input form="add" name="from" type="text" placeholder="From" />
    </td>
    <td>
        <input form="add" name="to" type="text" placeholder="To (url)" />
    </td>
    <td>
        <button form="add" class="add" type="submit">
            Add
        </button>
    </td>
</tr>
EOF;
    }
}
