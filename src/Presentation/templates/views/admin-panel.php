<?php
/** @var Presentation\Views\AdminPanel $this */
use Presentation\Components\AddEntry;
use Presentation\Components\Row;
use Presentation\Layouts\DefaultLayout;

$this->setLayout(new DefaultLayout("redirector-php admin panel"));
?>
<h1>Redirector-php admin panel</h1>

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
