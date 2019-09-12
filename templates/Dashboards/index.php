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
