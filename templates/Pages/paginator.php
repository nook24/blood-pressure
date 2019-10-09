<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="dataTables_info" style="line-height: 32px;">
            <?= __('Page'); ?>
            {{ paging.page }}
            <?= __('of'); ?>
            {{ paging.pageCount }},
            <?= __('Total'); ?>
            {{ paging.count }}
            <?= __('entries'); ?>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="dataTables_paginate paging_simple_numbers float-right" id="dataTable_paginate">
            <ul class="pagination">
                <li class="paginate_button page-item previous" ng-class="{ 'disabled': !paging.prevPage }"
                    title=" <?= __('First page') ?>">
                    <a href="javascript:void(0)" class="page-link" ng-click="changePage(1)">&lt;&lt;</a>
                </li>
                <li class="paginate_button page-item" ng-class="{ 'disabled': !paging.prevPage }"
                    title=" <?= __('Previous page') ?>">
                    <a href="javascript:void(0)" class="page-link" ng-click="prevPage()">&lt;</a>
                </li>


                <li class="paginate_button page-item" ng-repeat="i in pageNumbers() track by $index"
                    ng-class="{'active': i == paging.page}">
                    <a href="javascript:void(0);" class="page-link" ng-click="changePage(i)"> {{ i }} </a>
                </li>

                <li class="paginate_button page-item next" ng-class="{ 'disabled': !paging.nextPage }"
                    title=" <?= __('Next page') ?>">
                    <a href="javascript:void(0)" class="page-link" ng-click="nextPage()">&gt;</a>
                </li>
                <li class="paginate_button page-item" ng-class="{ 'disabled': !paging.nextPage }"
                    title=" <?= __('Last page') ?>">
                    <a href="javascript:void(0)" class="page-link" ng-click="changePage(paging.pageCount)">&gt;&gt;</a>
                </li>
            </ul>
        </div>
    </div>
</div>
