app.controller("UsersEditCtrl", function($scope, $http, $location, $routeParams){

    $scope.id = $routeParams.id;

    $scope.load = function(){
        $http.get("/users/edit/" + $scope.id + ".json",
            {}
        ).then(function(result){
            $scope.post = result.data.user;
        });
    };

    $scope.requestCsrf = function(){
        $http.get("/pages/csrf.json",
            $scope.post
        ).then(function(result){
            return;
        });
    };

    $scope.submit = function(){
        $http.post("/users/edit/" + $scope.id + ".json",
            $scope.post
        ).then(function(result){
            $scope.errors = {};
            console.log('Data saved successfully');
            $location.path("/Users");
        }, function errorCallback(result){
            $scope.requestCsrf();
            if(result.data.hasOwnProperty('error')){
                $scope.errors = result.data.error;
            }
        });
    };

    //Reset form on page load
    $scope.load();

});
