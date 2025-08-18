<?php
/** @var Features\Admin\Presentation\DefaultLayout\DefaultLayout $this */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $this->title ?></title>
        <style>
            <?= file_get_contents(getcwd() . "/assets/style.css") ?>
        </style>
    </head>
    <body>
        <?= $this->contents ?>
    </body>
</html>
