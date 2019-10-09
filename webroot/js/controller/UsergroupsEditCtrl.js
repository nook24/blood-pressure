app.controller("UsergroupsEditCtrl", function($scope, $http, $location, $routeParams){

    $scope.id = $routeParams.id;

    $scope.load = function(){
        $http.get("/usergroups/edit/" + $scope.id + ".json",
            {}
        ).then(function(result){
            $scope.post = {
                Usergroup: result.data.usergroup,
                Acos: {}
            };
            $scope.acos = result.data.acos;

            //Put all existing acos to $scope.post.Acos
            for(var aco in $scope.acos){
                for(var controller in $scope.acos[aco].children){
                    for(var action in $scope.acos[aco].children[controller].children){
                        var acoId = $scope.acos[aco].children[controller].children[action].id;
                        $scope.post.Acos[acoId] = 0;
                    }
                }
            }

            //Set permissions of current user group to $scope.post.Acos;
            for(var usergroupAco in result.data.usergroup.aro.acos){
                var usergroupAcoId = result.data.usergroup.aro.acos[usergroupAco].id;

                //Deny all by default
                $scope.post.Acos[usergroupAcoId] = 0;

                if(result.data.usergroup.aro.acos[usergroupAco]._joinData._create === "1"){
                    //Only enable what is enabled in the database
                    $scope.post.Acos[usergroupAcoId] = 1;
                }
            }
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
        $http.post("/usergroups/edit/" + $scope.id + ".json",
            $scope.post
        ).then(function(result){
            $scope.errors = {};
            console.log('Data saved successfully');
            $location.path("/Usergroups");
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
