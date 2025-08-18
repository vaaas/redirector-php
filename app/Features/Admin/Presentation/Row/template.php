<?php
use Features\Admin\Presentation\Row\Row;
/** @var Row $this */
$from = htmlspecialchars($this->from);
$to = htmlspecialchars($this->to);
?>
<tr>
    <td><?= $from ?></td>
    <td><a href="<?= $to ?>"><?= $to ?></a></td>
    <td>
        <button form="delete-<?= $from ?>" class="delete" name="entry" value="<?= $from ?>" type="submit">
            Delete
        </button>
    </td>
</tr>
