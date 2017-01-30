angular.module("ContenuServiceRest", ['ngResource'])

    .factory("contenuService",  function ($rootScope, $http, $resource) {

        //console.log($rootScope.headers);

        var res=null;
        //var t = JSON.parse(headers);



        var apiData = $resource(
            "/api", {},
            {
                     "getConteneurs": {method: 'GET', isArray: false, url: "/api/users/:userid/:anneeid/:groupeid/:niveauid"},
                      "getConteneur": {method: 'GET', isArray: false, url: "/api/lectureConteneur/:conteneurid"},
                          "getAnnee": {method: 'GET', isArray: true, url: "/api/promotion/annees"},
                         "getGroupe": {method: 'GET', isArray: true, url: "/api/promotion/groupes"},
                         "getNiveau": {method: 'GET', isArray: true, url: "/api/promotion/niveaux"},
                "getIsPasswordEmpty": {method: 'GET', isArray: false, url: "/api/users/checkPW/:useremail"},
                           "getUser": {method: 'GET', isArray: true, url: "/api/users/:email"},

                         "patchUser": {method: 'PATCH', url: "/api/users/:userid", userid: 'userid'},

                    "postAuthTokens": {method: 'POST', url: "/api/auth-tokens/:countClick"},
                      "postQuestion": { method: "POST", url: "/api/lectureContenu/:contenuid/:userid/:typequestionid/Questions"},

                  "deleteAuthToken": {method: 'DELETE', url: "/api/auth-tokens/:id"}
            });

            return {
                getGroupesContenus: function (user_id, annee_id, groupe_id, niveau_id) {
                    return apiData.getConteneurs({userid: user_id, anneeid: annee_id, groupeid: groupe_id, niveauid: niveau_id});
                },
                getConteneur: function (conteneur_id) {
                    return apiData.getConteneur({conteneurid: conteneur_id});
                },
                getAnnee: function () {
                    return apiData.getAnnee();
                },
                getGroupe: function () {
                    return apiData.getGroupe();
                },
                getNiveau: function () {
                    return apiData.getNiveau();
                },
                getUser: function (email) {
                    return apiData.getUser({email: email});
                },
          isPasswordEmpty: function (user_email) {
                    return apiData.getIsPasswordEmpty({useremail: user_email});
                },
                patchUser: function (userData, user_id) {
                    apiData.patchUser({userid: user_id}, userData, function() {
                        console.log("Success !");
                        return true;
                    }, function(error) {
                        console.log(error.data);
                    });
                },
                postAuthTokens: function(userData, countClick) {
                    return apiData.postAuthTokens({countClick: countClick}, userData, function() {
                        console.log("Success !");
                        return true;
                    }, function(error) {
                        console.log(error.data);
                        return false;
                    });


                },
                postQuestion: function(question, contenu_id, user_id, type_question_id) {
                    apiData.postQuestion({contenuid: contenu_id, userid: user_id, typequestionid: type_question_id}, question, function() {
                        console.log("Sucsess !");

                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                    });

                },

                deleteAuthToken: function(id) {
                    apiData.deleteAuthToken({id: id}, function() {
                        console.log("Sucsess !");
                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                    });

                }

        }
    });