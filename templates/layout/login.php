<!DOCTYPE html>
<html ng-app="BloodPressureLogin">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= __('Blood pressure - Login') ?>:
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('/css/sb-admin-2.min.css') ?>
    <?= $this->Html->css('/node_modules/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('/node_modules/noty/lib/noty.css') ?>
    <?= $this->Html->css('/node_modules/noty/lib/themes/metroui.css') ?>
    <?= $this->Html->css('/css/app.css') ?>

    <?= $this->Html->script('/node_modules/jquery/dist/jquery.min.js') ?>
    <?= $this->Html->script('/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>
    <?= $this->Html->script('/node_modules/noty/lib/noty.min.js') ?>

    <?= $this->Html->script('/node_modules/angular/angular.min.js') ?>
    <?= $this->Html->script('/node_modules/angular-route/angular-route.min.js') ?>
    <?= $this->Html->script('/js/ng.login-app.js') ?>

    <?= $this->Html->script('/js/controller/LoginCtrl.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body id="bg-gradient-primary">
<div class="container" ng-controller="LoginCtrl">
    <?= $this->fetch('content') ?>
</div>
</body>
</html>
