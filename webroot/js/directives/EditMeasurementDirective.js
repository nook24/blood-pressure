app.directive('editMeasurement', function($http){
    return {
        restrict: 'E',
        templateUrl: '/measurements/edit.html',

        controller: function($scope){

            var measurement;
            var callback;

            $scope.setObjectAndCallback = function(_measurement, _callback){
                measurement = _measurement;
                callback = _callback;
                $scope.currentEditMeasurement = {
                    systolic: measurement.systolic,
                    diastolic: measurement.diastolic,
                    heart_rate: measurement.heart_rate
                };
            };

            $scope.submitEdit = function(){
                $http.post("/measurements/edit/"+measurement.id+".json",
                    $scope.currentEditMeasurement
                ).then(function(result){
                    $scope.errors = {};
                    console.log('Data saved successfully');
                    $('.edit-measurement-modal-lg').modal('hide');
                    callback();
                }, function errorCallback(result){
                    if(result.data.hasOwnProperty('error')){
                        $scope.errors = result.data.error;
                    }
                });
            };

            $scope.deleteEdit = function(){
                $http.post("/measurements/delete.json", {
                    id: measurement.id
                }).then(function(result){
                    $('.edit-measurement-modal-lg').modal('hide');
                    callback();
                });
            };
        },

        link: function($scope, element, attr){
            $scope.editMeasurement = function(measurement, callback){
                $scope.setObjectAndCallback(measurement, callback);
                $('.edit-measurement-modal-lg').modal('show');
            };
        }
    };
});
