<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800"><?= __('Measurements') ?></h1>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <new-measurement callback="load"></new-measurement>
        <a ng-href="{{linkForPdf()}}" class="btn btn-sm btn-primary btn-icon-split float-right margin-right-10">
            <span class="icon text-gray-600">
                <i class="fa fa-download"></i>
            </span>
            <span class="text"><?= __('Download as PDF') ?></span>
        </a>
    </div>
</div>

<p class="mb-4">
    <span class="d-none d-lg-inline">
        <?= __('Document your blood pressure measurement result...') ?>
    </span>
</p>

<edit-measurement></edit-measurement>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive d-none d-md-inline">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Date') ?></th>
                        <th scope="col"><?= __('Systolic (mmHg)') ?></th>
                        <th scope="col"><?= __('Diastolic (mmHg)') ?></th>
                        <th scope="col"><?= __('Heart rate') ?></th>
                        <th scope="col"><?= __('Actions') ?></th>
                </thead>
                <tbody>
                    <tr ng-repeat="measurement in measurements" ng-class="{'table-warning': isWarning(measurement), 'table-danger': isDanger(measurement)}">
                        <td>{{measurement.created | date : 'HH:mm dd.MM.yyyy'}}</td>
                        <td>{{measurement.systolic}}</td>
                        <td>{{measurement.diastolic}}</td>
                        <td>{{measurement.heart_rate}}</td>
                        <td>
                            <span class="text-primary d-lg-none" ng-click="editMeasurement(measurement, load)" title="<?= __('Edit') ?>">
                                <i class="fa fa-pencil-square-o"></i>
                            </span>

                            <button class="btn btn-sm btn-primary d-none d-lg-inline" ng-click="editMeasurement(measurement, load)">
                                <i class="fa fa-pencil-square-o"></i>
                                <?= __('Edit') ?>
                            </button>
                            <button class="btn btn-sm btn-danger d-none d-lg-inline" ng-click="askDeleteMeasurement(measurement)">
                                <i class="fa fa-trash-o"></i>
                                <?= __('Delete') ?>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-md-none">
            <div ng-repeat="measurement in measurements">
                <div class="row">
                    <div class="col-12 text-right">
                        <span class="text-primary" ng-click="editMeasurement(measurement, load)" title="<?= __('Edit') ?>">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                    </div>
                </div>

                <dl class="row">
                    <dt class="col-6"><?= __('Date') ?>:</dt>
                    <dd class="col-6">{{measurement.created | date : 'HH:mm dd.MM.yyyy'}}</dd>

                    <dt class="col-6"><?= __('Systolic') ?>:</dt>
                    <dd class="col-6" ng-class="{'text-bold text-warning': isWarning(measurement), 'text-bold text-danger': isDanger(measurement)}">
                        {{measurement.systolic}}
                    </dd>

                    <dt class="col-6"><?= __('Diastolic') ?>:</dt>
                    <dd class="col-6" ng-class="{'text-bold text-warning': isWarning(measurement), 'text-bold text-danger': isDanger(measurement)}">
                        {{measurement.diastolic}}
                    </dd>

                    <dt class="col-6"><?= __('Heart rate') ?>:</dt>
                    <dd class="col-6">{{measurement.heart_rate}}</dd>
                </dl>
                <hr />
            </div>
        </div>

        <paginator paging="paging" click-action="changepage" ng-if="paging"></paginator>

    </div>
</div>


<div class="modal fade delete-measurement-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header bg-danger text-white">
                <h5 class="modal-title"><?= __('Delete measurement?') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Close') ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?= __('Do you really want to delete the selected record?') ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <?= __('Cancel') ?>
                </button>
                <button type="button" class="btn btn-danger" ng-click="delete()">
                    <?= __('Delete') ?>
                </button>
            </div>

        </div>
    </div>