app.controller("MeasurementsIndexCtrl", function($scope, $http, $httpParamSerializer){
    $scope.currentPage = 1;

    var measurementToDelete = null;

    $scope.load = function(){
        $http.get("/measurements/index.json", {
            params: {
                page: $scope.currentPage
            }
        }).then(function(result){
            $scope.measurements = result.data.measurements;
            $scope.paging = result.data.paging;
        });
    };

    $scope.isWarning = function(measurement){
        if(measurement.systolic >= 130 && measurement.diastolic >= 80){
            return true;
        }
        return false;
    };


    $scope.isDanger = function(measurement){
        if(measurement.systolic >= 140 && measurement.diastolic >= 90){
            return true;
        }
        return false;
    };

    $scope.askDeleteMeasurement = function(measurement){
        measurementToDelete = measurement;
        $('.delete-measurement-modal-lg').modal('show');
    };

    $scope.delete = function(){
        $http.post("/measurements/delete.json", {
            id: measurementToDelete.id
        }).then(function(result){
            $scope.load();
            $('.delete-measurement-modal-lg').modal('hide');
        });
        measurementToDelete = null;
    };

    $scope.changepage = function(page){
        if(page !== $scope.currentPage){
            $scope.currentPage = page;
            $scope.load();
        }
    };

    $scope.linkForPdf = function(){

        var baseUrl = '/measurements/index.pdf?';

        return baseUrl + $httpParamSerializer({
            page: $scope.currentPage
        });

    };

    //Fire on page load
    $scope.load();

});
