<?php
use Features\Admin\Presentation\AddEntry\AddEntry;
use Features\Admin\Presentation\AdminPanel\AdminPanel;
use Features\Admin\Presentation\DefaultLayout\DefaultLayout;
use Features\Admin\Presentation\Row\Row;

/** @var AdminPanel $this */

$title = "redirector-php admin panel";
$this->setLayout(new DefaultLayout($title));
?>
<h1><?= $title ?></h1>

<form id="add" action="/?add" method="post"></form>

<?php foreach (array_keys($this->links) as $k): ?>
    <form id="delete-<?= $k ?>" action="/?delete" method="post"></form>
<?php endforeach; ?>

<table>
    <tr>
        <th>Resource</th>
        <th>Destination</th>
    </tr>

    <?= new AddEntry() ?>

    <?php foreach ($this->links as $k => $v): ?>
        <?= new Row($k, $v) ?>
    <?php endforeach; ?>
</table>

<style>
h1 {
    display: block;
    padding-bottom: 1rem;
    font-weight: bold;
}

table {
    display: table;
}

tr {
    display: table-row;
}

td,
th {
    display: table-cell;
}

td + td,
th + th {
    padding-left: 1rem;
}

th {
    color: var(--s00);
}
</style>
