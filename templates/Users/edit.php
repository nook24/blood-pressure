<?php

/**
 * @var \App\View\AppView $this
 */
?>


<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h1 class="h3 mb-2 text-gray-800">
            <?= __('Edit user') ?>:
            &raquo;{{post.username}}&laquo;
        </h1>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">

        <form ng-submit="submit()">
            <div class="form-group" ng-class="{'has-error': errors.username}">
                <label for="username" class="col-form-label">
                    <?= __('Username') ?>
                </label>
                <input type="text" class="form-control" id="username" ng-model="post.username">
                <div ng-repeat="error in errors.username" class="error-feedback">
                    {{error}}
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.firstname}">
                <label for="firstname" class="col-form-label">
                    <?= __('First name') ?>
                </label>
                <input type="text" class="form-control" id="firstname" ng-model="post.firstname">
                <div ng-repeat="error in errors.firstname" class="error-feedback">
                    {{error}}
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.lastname}">
                <label for="lastname" class="col-form-label">
                    <?= __('Last name') ?>
                </label>
                <input type="text" class="form-control" id="lastname" ng-model="post.lastname" autocomplete="new-user">
                <div ng-repeat="error in errors.lastname" class="error-feedback">
                    {{error}}
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.password}">
                <label for="password" class="col-form-label">
                    <?= __('Password') ?>
                </label>
                <input type="password" class="form-control" id="password" ng-model="post.password" autocomplete="new-password">
                <div ng-repeat="error in errors.password" class="error-feedback">
                    {{error}}
                </div>
                <div class="input-help">
                    <?= __('Leave blank if you don\'t want to change the password.') ?>
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal" ng-href="#!Users">
                    <?= __('Cancel') ?>
                </a>
                <input type="submit" class="btn btn-success" value="<?= __('Save') ?>">
            </div>
        </form>

    </div>
</div>