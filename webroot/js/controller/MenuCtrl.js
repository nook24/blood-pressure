app.controller("MenuCtrl", function ($scope, $http, $location) {
    
    $scope.hideSidebar = localStorage.getItem('hideSidebar') === 'true';

    $scope.showOrHideSidebar = function(){
        if($scope.hideSidebar === true){
            $scope.hideSidebar = false;
            localStorage.setItem('hideSidebar', 'false');
        }else{
            localStorage.setItem('hideSidebar', 'true');
            $scope.hideSidebar = true;
        }
    };

    $scope.isActive = function(path){
        return $location.path() === path;
    };

    
});