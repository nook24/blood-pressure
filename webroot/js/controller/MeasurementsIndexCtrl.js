app.controller("MeasurementsIndexCtrl", function ($scope, $http) {
    $scope.currentPage = 1;

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

    $scope.changepage = function(page){
        if(page !== $scope.currentPage){
            $scope.currentPage = page;
            $scope.load();
        }
    };

    //Fire on page load
    $scope.load();
    
});