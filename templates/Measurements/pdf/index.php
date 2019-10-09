<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Measurement[]|\Cake\Collection\CollectionInterface $measurements
 */
?>

<h1 class="h3 mb-4 text-gray-800"><?= __('Measurements') ?></h1>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Systolic (mmHg)') ?></th>
                <th scope="col"><?= __('Diastolic (mmHg)') ?></th>
                <th scope="col"><?= __('Heart rate') ?></th>
            </thead>
            <tbody>
            <?php foreach ($measurements as $measurement) : ?>
                <?php
                $class = '';
                if ($measurement->get('systolic') >= 130 && $measurement->get('diastolic') >= 80) :
                    $class = 'table-warning';
                endif;

                if ($measurement->get('systolic') >= 140 && $measurement->get('diastolic') >= 90) :
                    $class = 'table-danger';
                endif;
                ?>
                <tr class="<?= $class ?>">
                    <td><?= h($measurement->get('created')->format('H:m d.m.Y')); ?></td>
                    <td><?= h($measurement->get('systolic')) ?></td>
                    <td><?= h($measurement->get('diastolic')) ?></td>
                    <td><?= h($measurement->get('heart_rate')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-9">
                <div class="dataTables_info" style="line-height: 32px;">
                    <?= __('Page') ?>
                    <?= $paging['page'] ?>
                    <?= __('of') ?>
                    <?= $paging['pageCount'] ?>
                    <?= __('Total') ?>
                    <?= $paging['count'] ?>
                    <?= __('entries') ?>
                </div>
            </div>
            <div class="col-3">
                <div class="dataTables_paginate paging_simple_numbers float-right" id="dataTable_paginate">
                    <ul class="pagination">
                        <li class="paginate_button page-item active">
                            <a href="javascript:void(0);" class="page-link"> <?= $paging['page'] ?> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
