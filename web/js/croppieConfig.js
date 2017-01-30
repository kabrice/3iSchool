angular.module("myServiceRest", ['ngResource'])

    .factory("myService",  function ($rootScope, $resource) {

        

        var apiData = $resource(
            "/api", {},
            {
                "getContains": {method: 'GET', isArray: false, url: "/api/users/:userid/:yearid/:groupeid/:levelid", headers: $rootScope.headers},
                "getContain": {method: 'GET', isArray: false, url: "/api/Contains/:containid", headers: $rootScope.headers},
                
                "postAuthTokens": {method: 'POST', url: "/api/auth-tokens"}
                
            });

        return {
            getGroupesContenus: function (user_id, year_id, groupe_id, level_id) {
                return apiData.getContains({userid: user_id, yearid: year_id, groupeid: groupe_id, levelid: level_id});
            },
            getContain: function (contain_id) {
                return apiData.getContain({containid: contain_id});
            },
         
            postAuthTokens: function(userData) {
                apiData.postAuthTokens(userData, function (data) {
                    console.log("success !");
                    $rootScope.headers = {
                        "Content-Type": "application/json",
                        "Authorization": "Basic ZWRnYXJrYW1kZW06TkVXVE9O",
                        "Accept": "application/json",
                        "X-Auth-Token": data.value
                    };
                }, function (error) {
                    console.log(error.data);
                })

            }
        }
    });