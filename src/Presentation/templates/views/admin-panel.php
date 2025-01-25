<?php
/** @var Presentation\Views\AdminPanel $this */
use Presentation\Components\AddEntry;
use Presentation\Components\Row;
use Presentation\Layouts\DefaultLayout;

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
