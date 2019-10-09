app.controller("UsergroupsAddCtrl", function ($scope, $http, $location) {

    $scope.resetForm = function () {
        $scope.post = {
            Usergroup: {
                name: null
            },
            Acos: {}
        };
    };

    $scope.loadAcos = function () {
        $http.get("/usergroups/add.json",
            {}
        ).then(function (result) {
            $scope.acos = result.data.acos;

            for(var aco in $scope.acos){
                for(var controller in $scope.acos[aco].children){
                    for(var action in $scope.acos[aco].children[controller].children){
                        var acoId = $scope.acos[aco].children[controller].children[action].id;
                        $scope.post.Acos[acoId] = 0;
                    }
                }
            }
        });
    };

    $scope.requestCsrf = function () {
        $http.get("/pages/csrf.json",
            $scope.post
        ).then(function (result) {
            return;
        });
    };

    $scope.submit = function () {
        $http.post("/usergroups/add.json",
            $scope.post
        ).then(function (result) {
            $scope.errors = {};
            console.log('Data saved successfully');
            $location.path("/Usergroups");
        }, function errorCallback(result) {
            $scope.requestCsrf();
            if (result.data.hasOwnProperty('error')) {
                $scope.errors = result.data.error;
            }
        });
    };

    //Reset form on page load
    $scope.resetForm();
    $scope.requestCsrf();
    $scope.loadAcos();

});
