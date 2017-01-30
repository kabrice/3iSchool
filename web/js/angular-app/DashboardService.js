angular.module("DashboardService", ['ngResource'])

    .factory("dashboardService",  function ($scope, $resource) {

        var headers = {
            "Content-Type": "application/json",
            "Authorization": "Basic ZWRnYXJrYW1kZW06TkVXVE9O",
            "Accept": "application/json",
            "X-Auth-Token": "azerty",
            "Access-Control-Allow-Origin": "*"
        };

        var api = $resource(
            "/api", {},
            {
                "getQuestions":         {method: 'GET', isArray: true, url: "/api/listerQuestion/Contenu", headers: headers},
                "getContenuSignale":    {method: 'GET', isArray: true, url: "/api/listerContenuSignale/Contenu", headers: headers},
                "getCoursEtMatieres":   {method: 'GET', isArray: true, url: "/api/listerCoursEtMatieres/Contenu", headers: headers},
                "postContenu" : {method: "POST", url: "/api/contenu/:annee_id/:groupe_id/:niveau_id/:rubrique_id/:sous_rubrique_id/:user_id/Contenu", headers: headers}
            });

        return {
            getQuestions: function () {
                return api.getQuestions();
            },
            getContenuSignale: function () {
                return api.getContenuSignale();
            },
            getCoursEtMatieres: function () {
                return api.getCoursEtMatiers();
            },
            postContenu: function(contenu, anneeId, groupeId, niveauId, rubriqueId, sous_rubriqueId, userId) {
                api.postEcritureContenu({annee_id: anneeId, groupe_id: groupeId, niveau_id: niveauId, rubrique_id: rubriqueId, sous_rubrique_id: sous_rubriqueId, user_id: userId}, contenu, function(reponse) {
                    console.log("Sucsess !");
                }, function(error) {
                    console.log("Error " + error.status + " when sending request : " + error.data);
                });
            }
        }
    });