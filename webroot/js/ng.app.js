var app = angular.module("BloodPressure", ["ngRoute"]);

app.factory("httpRequestInterceptor", function($rootScope, $q, $location){
    return {
        response: function(result){
            if(result.data.hasOwnProperty('_csrfToken')){
                $rootScope._csrfToken = result.data._csrfToken;
            }
            return result || $.then(result)
        },
        request: function(config){
            if(config.method !== 'GET'){
                config.headers['X-CSRF-Token'] = $rootScope._csrfToken;
            }
            return config;
        },
        responseError: function(rejection){
            if(rejection.status == 401){
                window.location = '/users/login';
            }
            if(rejection.status == 403){
                $location.path('/403');
            }
            return $q.reject(rejection);
        }
    };
});

app.config(function($httpProvider){
    $httpProvider.interceptors.push('httpRequestInterceptor');
});

app.config(function($routeProvider){

    $routeProvider
        .when("/403", {
            templateUrl: "/Pages/error403.html",
            controller: "Error403Ctrl"
        })

        .when("/Measurements", {
            templateUrl: "/Measurements/index.html",
            controller: "MeasurementsIndexCtrl"
        })

        .when("/Users", {
            templateUrl: "/Users/index.html",
            controller: "UsersIndexCtrl"
        })
        .when("/Users/add", {
            templateUrl: "/Users/add.html",
            controller: "UsersAddCtrl"
        })
        .when("/Users/edit/:id", {
            templateUrl: "/Users/edit.html",
            controller: "UsersEditCtrl"
        })

        .when("/Usergroups", {
            templateUrl: "/Usergroups/index.html",
            controller: "UsergroupsIndexCtrl"
        })
        .when("/Usergroups/add", {
            templateUrl: "/Usergroups/add.html",
            controller: "UsergroupsAddCtrl"
        })
        .when("/Usergroups/edit/:id", {
            templateUrl: "/Usergroups/edit.html",
            controller: "UsergroupsEditCtrl"
        })

        .when("/Dashboard", {
            templateUrl: "/Dashboards/index.html",
            controller: "DashboardsIndexCtrl"
        })
        .otherwise({
            redirectTo: '/Dashboard'
        });
});
