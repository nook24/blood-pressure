<?php
/**
 * Ship the main application layout to the browser
 *
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html ng-app="BloodPressure">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php //$this->Html->css('milligram.min.css') ?>
    <?php //$this->Html->css('cake.css') ?>

    <?php // echo $this->Html->css('/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>
    <?= $this->Html->css('/css/sb-admin-2.min.css') ?>
    <?= $this->Html->css('/node_modules/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('/css/app.css') ?>


    <?= $this->Html->script('/node_modules/jquery/dist/jquery.min.js') ?>
    <?= $this->Html->script('/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>

    <?= $this->Html->script('/node_modules/angular/angular.min.js') ?>
    <?= $this->Html->script('/node_modules/angular-route/angular-route.min.js') ?>
    <?= $this->Html->script('/js/ng.app.js') ?>

    <?= $this->Html->script('/js/controller/MenuCtrl.js') ?>

    <?= $this->Html->script('/js/controller/MeasurementsIndexCtrl.js') ?>

    <?= $this->Html->script('/js/directives/NewMeasurementDirective.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" ng-controller="MenuCtrl">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text">
                    <?= __('Blood Pressure') ?>
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item" ng-class="{'active': isActive('/Measurements')}">
                <a class="nav-link" ng-href="#!Measurements">
                    <i class="fa fa-heartbeat"></i>
                    <span><?= __('Measurements') ?></span>
                </a>
            </li>

            <li class="nav-item" ng-class="{'active': isActive('/Users')}">
                <a class="nav-link" ng-href="#!Users">
                    <i class="fa fa-user"></i>
                    <span><?= __('Users') ?></span>
                </a>
            </li>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link" href="/users/logout">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= __('Logout') ?>
                                </span>
                            </a>
                        </li>
                    </ul>

                </nav>

                <div class="container-fluid">
                    <div ng-view></div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
