app.controller("MenuCtrl", function ($scope, $http, $location) {
    
    $scope.isActive = function(path){
        return $location.path() === path;
    }
    
});