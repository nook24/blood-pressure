<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800"><?= __('Users') ?></h1>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <a class="btn btn-sm btn-success btn-icon-split float-right" ng-href="/#!Users/add">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text"><?= __('New user') ?></span>
        </a>
    </div>
</div>

<p class="mb-4">
    <span class="d-none d-lg-inline">
        <?= __('Mange web interface users...') ?>
    </span>
</p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= __('#') ?></th>
                        <th scope="col"><?= __('Username') ?></th>
                        <th scope="col"><?= __('First name') ?></th>
                        <th scope="col"><?= __('Last name') ?></th>
                        <th scope="col"><?= __('Actions') ?></th>
                </thead>
                <tbody>
                    <tr ng-repeat="user in users">
                        <td>{{user.id}}</td>
                        <td>{{user.username}}</td>
                        <td>{{user.firstname}}</td>
                        <td>{{user.lastname}}</td>
                        <td>

                            <a class="btn btn-sm btn-primary" ng-href="/#!Users/edit/{{user.id}}">
                                <i class="fa fa-pencil-square-o"></i>
                                <?= __('Edit') ?>
                            </a>
                            <button class="btn btn-sm btn-danger" ng-click="askDeleteUser(user)" ng-show="user.id !== myself">
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

<div class="modal fade delete-user-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header bg-danger text-white">
                <h5 class="modal-title"><?= __('Delete user?') ?></h5>
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