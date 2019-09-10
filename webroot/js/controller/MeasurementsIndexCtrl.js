app.controller("MeasurementsIndexCtrl", function ($scope, $http) {
    
    $scope.msg = "This is a test";

    $scope.load = function(){
        var params = {};
        $http.get("/measurements/index.json",
            params
        ).then(function(result){
            $scope.measurements = result.data.measurements;
        });
    };

    //Fire on page load
    $scope.load();
    
});