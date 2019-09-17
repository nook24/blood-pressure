<?php

/**
 *
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <link rel="stylesheet" href="<?= WWW_ROOT ?>node_modules/chart.js/dist/Chart.min.css"/> 
    <link rel="stylesheet" href="<?= WWW_ROOT ?>css/pdf/sb-admin-2.css"/> 
    <link rel="stylesheet" href="<?= WWW_ROOT ?>node_modules/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?= WWW_ROOT ?>css/app.css"/> 


</head>

<body id="page-top">
    <div class="container-fluid">
        <?= $this->fetch('content') ?>
    </div>
</body>

</html>