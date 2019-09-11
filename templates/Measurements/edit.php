<div class="modal fade edit-measurement-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >
            <div class="modal-header">
            <h5 class="modal-title"><?= __('Edit measurement') ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Close') ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <form ng-submit="submitEdit()">
                <div class="form-group" ng-class="{'has-error': errors.systolic}">
                    <label for="systolic" class="col-form-label">
                        <?= __('Systolic (mmHg)') ?>
                    </label>
                    <input type="number" class="form-control" id="systolic" min="0" placeholder="120"
                           ng-model="currentEditMeasurement.systolic">
                    <div ng-repeat="error in errors.systolic" class="error-feedback">
                        {{error}}
                    </div>
                </div>

                <div class="form-group" ng-class="{'has-error': errors.diastolic}">
                    <label for="diastolic" class="col-form-label">
                        <?= __('Diastolic (mmHg)') ?>
                    </label>
                    <input type="number" class="form-control" id="diastolic" min="0" placeholder="80"
                           ng-model="currentEditMeasurement.diastolic">
                    <div ng-repeat="error in errors.diastolic" class="error-feedback">
                        {{error}}
                    </div>
                </div>

                <div class="form-group" ng-class="{'has-error': errors.heart_rate}">
                    <label for="heart_rate" class="col-form-label">
                        <?= __('Heart rate') ?>
                    </label>
                    <input type="number" class="form-control" id="heart_rate" min="0" placeholder="60"
                           ng-model="currentEditMeasurement.heart_rate">
                    <div ng-repeat="error in errors.diastolic" class="error-feedback">
                        {{error}}
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" style="margin-right: auto;" ng-click="deleteEdit()">
                <?= __('Delete') ?>
            </button>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <?= __('Close') ?>
            </button>
            <button type="button" class="btn btn-success" ng-click="submitEdit()">
                <?= __('Save') ?>
            </button>
        </div>

    </div>
</div>
