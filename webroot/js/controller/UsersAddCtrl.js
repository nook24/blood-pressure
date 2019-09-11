app.controller("UsersAddCtrl", function ($scope, $http, $location) {

    $scope.resetForm = function(){
        $scope.post = {
            username: null,
            password: null,
            firstname: null,
            lastname: null
        };
    };

    $scope.requestCsrf = function(){
        $http.get("/pages/csrf.json",
            $scope.post
        ).then(function(result){
            return;
        });
    };

    $scope.submit = function(){
        $http.post("/users/add.json",
            $scope.post
        ).then(function(result){
            $scope.errors = {};
            console.log('Data saved successfully');
            $location.path( "/Users" );
        }, function errorCallback(result){
            $scope.requestCsrf();
            if(result.data.hasOwnProperty('error')){
                $scope.errors = result.data.error;
            }
        });
    };

    //Reset form on page load
    $scope.resetForm();
    $scope.requestCsrf();
    
});