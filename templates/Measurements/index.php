<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Measurement[]|\Cake\Collection\CollectionInterface $measurements
 */
?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800"><?= __('Measurements') ?></h1>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <new-measurement callback="load"></new-measurement>
    </div>
</div>

<p class="mb-4">
    <?= __('Document your blood pressure measurement result...') ?>
</p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
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
                    <tr ng-repeat="measurement in measurements">
                        <td>{{measurement.created}}</td>
                        <td>{{measurement.systolic}}</td>
                        <td>{{measurement.diastolic}}</td>
                        <td>{{measurement.heart_rate}}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" ng-click="editMeasurement(measurement)">
                                <i class="fa fa-pencil-square-o"></i>
                                <?= __('Edit') ?>
                            </button>
                            <button class="btn btn-sm btn-danger" ng-click="deleteMeasurement(measurement)">
                                <i class="fa fa-trash-o"></i>
                                <?= __('Delete') ?>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <paginator paging="paging" click-action="changepage" ng-if="paging"></paginator>

    </div>
</div>


