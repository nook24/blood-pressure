<?php

/**
 * @var \App\View\AppView $this
 */
?>


<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800"><?= __('Dashboard') ?></h1>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <new-measurement callback="update"></new-measurement>
        <button class="btn btn-sm btn-primary btn-icon-split float-right margin-right-10" ng-click="update()">
            <span class="icon text-gray-600">
                <i class="fa fa-refresh"></i>
            </span>
            <span class="text"><?= __('Reload') ?></span>
        </button>
    </div>
</div>

<p class="mb-4">
    <span class="d-none d-lg-inline">
        <?= __('Overview about your last measurements...') ?>
    </span>
</p>

<p class="mb-4">
    <?= __('Last measurement') ?>
    -
    {{lastMeasurement.created | date : 'HH:mm dd.MM.yyyy'}}
</p>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-systolic shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-systolic mb-1">
                            <?= __('Systolic') ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{lastMeasurement.systolic}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-diastolic shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-diastolic mb-1">
                            <?= __('Diastolic') ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{lastMeasurement.diastolic}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info mb-1">
                            <?= __('Heart rate') ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{lastMeasurement.heart_rate}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('History Overview') ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Calendar Overview') ?></h6>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>