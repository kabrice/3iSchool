angular.module("ContenuServiceHttp", ['angular.filter'])
    .factory("contenuService", ['$rootScope', '$filter', '$http', function ($rootScope, $filter, $http) {

        var config = {
            headers: {
                'Authorization': 'Basic d2VudHdvcnRobWFuOkNoYW5nZV9tZQ==',
                'Accept': 'application/json;odata=verbose',
                "X-Auth-Token": "azerty"
            }
        };

        //console.log($http.get("/api/users/1/3/2/3", config));

        return {
            getGroupesContenus: function (user_id, annee_id, groupe_id, niveau_id) {
                var promesse = $http.get("/api/users/"+user_id+"/"+annee_id+"/"+groupe_id+"/"+niveau_id, config);
                var groupesContenus = [];
                promesse.then(function (reponse) {
                   //console.log(reponse.data);
                    angular.extend(groupesContenus, reponse.data);

                }, function (erreur) {
                    console("Erreur " + groupesContenus.status + " lors de la récupération des données : " + erreur.data);
                });
                console.log(groupesContenus);
                return groupesContenus;
            },
            getConteneur: function (conteneur_id) {
                var promesse = $http.get("http://127.0.0.1:8000/api/lectureConteneur/"+conteneur_id, config);
                var resultat = [];
                promesse.then(function (reponse) {
                    angular.extend(resultat, reponse.data);
                }, function (erreur) {
                    console("Erreur " + resultat.status + " lors de la récupération des données : " + erreur.data);
                });
                console.log(resultat);
                return resultat;
            },
            postQuestion: function (questions, question) {

            }

        }
    }])