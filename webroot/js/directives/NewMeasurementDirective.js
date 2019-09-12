app.directive('newMeasurement', function ($http) {
    return {
        restrict: 'E',
        templateUrl: '/measurements/add.html',
        scope: {
            callback: '='
        },

        controller: function ($scope) {
            $scope.resetForm = function () {
                $scope.post = {
                    systolic: null,
                    diastolic: null,
                    heart_rate: null
                };
            };

            $scope.submit = function () {
                $http.post("/measurements/add.json",
                    $scope.post
                ).then(function (result) {
                    $scope.errors = {};
                    console.log('Data saved successfully');
                    $('.new-measurement-modal-lg').modal('hide');
                    $scope.callback();
                }, function errorCallback(result) {
                    if (result.data.hasOwnProperty('error')) {
                        $scope.errors = result.data.error;
                    }
                });
            };

            //Reset form on page load
            $scope.resetForm();
        },

        link: function ($scope, element, attr) { }
    };
});
