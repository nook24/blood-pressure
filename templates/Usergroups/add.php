<?php

/**
 * @var \App\View\AppView $this
 */
?>


<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800"><?= __('Create new user group') ?></h1>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">

        <form ng-submit="submit()">
            <div class="form-group" ng-class="{'has-error': errors.name}">
                <label for="name" class="col-form-label">
                    <?= __('Group name') ?>
                </label>
                <input type="text" class="form-control" id="name"
                       ng-model="post.Usergroup.name" placeholder="<?= __('Doctors') ?>">
                <div ng-repeat="error in errors.name" class="error-feedback">
                    {{error}}
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?= __('Permissions'); ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row" ng-repeat="aco in acos">
                        <div class="col-12">
                            <div class="row padding-bottom-15" ng-repeat="controller in aco.children" ng-if="controller.children.length > 0">
                                <div class="col-xs-12">
                                    <h5>{{controller.alias}}</h5>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-2 col-lg-4"
                                             ng-repeat="action in controller.children">
                                            <label class="form-check-label">
                                                <input type="checkbox" ng-model="post.Acos[action.id]"
                                                       ng-true-value="1"
                                                       ng-false-value="0"/>
                                                {{action.alias}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal" ng-href="#!Usergroups">
                    <?= __('Cancel') ?>
                </a>
                <input type="submit" class="btn btn-success" value="<?= __('Save') ?>">
            </div>
        </form>

    </div>
</div>
