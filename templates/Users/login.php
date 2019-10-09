<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Measurement[]|\Cake\Collection\CollectionInterface $measurements
 */
?>

<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        <div id="login-unsplash-credit">
                            <?= __('Photo by') ?>
                            <a href="https://unsplash.com/@joelfilip?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText"
                               target="_blank">
                                Joel Filipe
                            </a>
                            <?= __('on') ?>
                            <a href="https://unsplash.com/?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText"
                               target="_blank">
                                Unsplash
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= __('Welcome Back!') ?></h1>
                            </div>
                            <form class="user" ng-submit="submit();">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                           placeholder="<?= __('Username') ?>" ng-model="post.username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                           placeholder="<?= __('Password') ?>" ng-model="post.password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck"
                                               ng-true-value="1" ng-false-value="0" ng-model="post.remember_me">
                                        <label class="custom-control-label" for="customCheck">
                                            <?= __('Remember Me') ?>
                                        </label>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block"
                                       value="<?= __('Login') ?>">

                                <div style="height: 180px;" class="d-none d-lg-block">
                                    <!-- Spacer to show more image -->
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
