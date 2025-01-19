<?php
use Components\AddEntry;
use Components\Row;

/** @var Views\AdminPanel $this */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>redirector-php admin panel</title>
        <style>
            <?= file_get_contents(__DIR__ . "/style.css") ?>
        </style>
    </head>
    <body>
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
    </body>
</html>
