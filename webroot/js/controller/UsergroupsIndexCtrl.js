app.controller("UsergroupsIndexCtrl", function ($scope, $http) {
    $scope.currentPage = 1;

    var usergroupToDelete = null;

    $scope.load = function () {
        $http.get("/usergroups/index.json", {
            params: {
                page: $scope.currentPage
            }
        }).then(function (result) {
            $scope.usergroups = result.data.usergroups;
            $scope.myself = result.data.myself;
            $scope.paging = result.data.paging;
        });
    };

    $scope.askDeleteUsergroup = function (usergroup) {
        usergroupToDelete = usergroup;
        $('.delete-usergroup-modal-lg').modal('show');
    };

    $scope.delete = function () {
        $http.post("/usergroups/delete.json", {
            id: usergroupToDelete.id
        }).then(function (result) {
            $scope.load();
            $('.delete-usergroup-modal-lg').modal('hide');
        });
        usergroupToDelete = null;
    };

    $scope.changepage = function (page) {
        if (page !== $scope.currentPage) {
            $scope.currentPage = page;
            $scope.load();
        }
    };

    //Fire on page load
    $scope.load();

});
