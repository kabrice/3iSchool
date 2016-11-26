angular.module("3ischool", [])
    .config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    })
    .controller("3ischoolCtrl",function ($scope) {
        $httpProvider.interceptors.push(function($q, $cookies) {
            return {
                'request': function(config) {

                    config.headers['X-Auth-Token'] = "azerty";
                    return config;
                }
            };
        });

    });