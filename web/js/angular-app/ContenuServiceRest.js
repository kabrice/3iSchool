angular.module("ContenuServiceRest", ['ngResource'])

    .factory("contenuService",  function ($rootScope, $resource) {

        var headers = {
            "Content-Type": "application/json",
            "Authorization": "Basic ZWRnYXJrYW1kZW06TkVXVE9O",
            "Accept": "application/json",
            "X-Auth-Token": "azerty",
            "Access-Control-Allow-Origin": "*"
        };

        var apiData = $resource(
            "/api", {},
            {
                     "getConteneurs": {method: 'GET', isArray: false, url: "/api/users/:userid/:anneeid/:groupeid/:niveauid", headers: headers},
                      "getConteneur": {method: 'GET', isArray: false, url: "/api/lectureConteneur/:conteneurid", headers: headers},
                          "getAnnee": {method: 'GET', isArray: true, url: "/api/promotion/annees", headers: headers},
                         "getGroupe": {method: 'GET', isArray: true, url: "/api/promotion/groupes", headers: headers},
                         "getNiveau": {method: 'GET', isArray: true, url: "/api/promotion/niveaux", headers: headers},
                //"getIsPasswordEmpty": {method: 'GET', isArray: false, url: "/api/users/checkPW/:useremail"},

                "getIsPasswordEmpty": {method: 'GET', isArray: false, url: "/api/users/checkPW/:useremail"},

                      "postQuestion" : { method: "POST", url: "/api/lectureContenu/:contenuid/:userid/:typequestionid/Questions", headers: headers}
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
          isPasswordEmpty: function (user_email) {
                    return apiData.getIsPasswordEmpty({useremail: user_email});
                },
                postQuestion: function(question, contenu_id, user_id, type_question_id) {
                    apiData.postQuestion({contenuid: contenu_id, userid: user_id, typequestionid: type_question_id}, question, function(reponse) {
                        console.log("Sucsess !");
                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                    });

                }

        }
    });