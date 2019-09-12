var app = angular.module("BloodPressure", ["ngRoute"]);

app.factory("httpRequestInterceptor", function ($rootScope, $q) {
    return {
        response: function(result){
            if(result.data.hasOwnProperty('_csrfToken')){
                $rootScope._csrfToken = result.data._csrfToken;
            }
            return result || $.then(result)
        },
        request: function (config){
            if(config.method !== 'GET'){
                config.headers['X-CSRF-Token'] = $rootScope._csrfToken;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status == 401) {
                window.location = '/users/login';
            }
            return $q.reject(rejection);
        }
    };
});

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('httpRequestInterceptor');
});

app.config(function($routeProvider) {

    $routeProvider
        .when("/Measurements", {
            templateUrl : "/Measurements/index.html",
            controller: "MeasurementsIndexCtrl"
        })
        .when("/Users", {
            templateUrl : "/Users/index.html",
            controller: "UsersIndexCtrl"
        })
        .when("/Users/add", {
            templateUrl : "/Users/add.html",
            controller: "UsersAddCtrl"
        })
        .when("/Users/edit/:id", {
            templateUrl : "/Users/edit.html",
            controller: "UsersEditCtrl"
        })
        .otherwise({
            redirectTo:'/Measurements'
        });
});