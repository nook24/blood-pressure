app.controller("UsersIndexCtrl", function($scope, $http){
    $scope.currentPage = 1;

    var userToDelete = null;

    $scope.load = function(){
        $http.get("/users/index.json", {
            params: {
                page: $scope.currentPage
            }
        }).then(function(result){
            $scope.users = result.data.users;
            $scope.myself = result.data.myself;
            $scope.paging = result.data.paging;
        });
    };

    $scope.askDeleteUser = function(user){
        userToDelete = user;
        $('.delete-user-modal-lg').modal('show');
    };

    $scope.delete = function(){
        $http.post("/users/delete.json", {
            id: userToDelete.id
        }).then(function(result){
            $scope.load();
            $('.delete-user-modal-lg').modal('hide');
        });
        userToDelete = null;
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
