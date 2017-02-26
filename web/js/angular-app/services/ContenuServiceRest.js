angular.module("ContenuServiceRest", ['ngResource'])

    .factory("contenuService",  function ($rootScope, $http, $resource, $q) {

        //console.log($rootScope.headers);

        var res=null;




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
                       "getUserVote": {method: 'GET', isArray: false, url: "/api/vote/:refid/:ref/:userid"},
              "getRubriqueDashboard": {method: 'GET', isArray: true, url: "/api/user/:userid/:numRubrique/contenus/questions/reponses"},
                     "getUserReview": {method: 'GET', isArray: true, url: "/api/contenu/:contenuid/:userid/review"},
                       "getUserNote": {method: 'GET', isArray: true, url: "/api/contenu/:contenuid/:userid/note"},
                      "getRubriques": {method: 'GET', isArray: true, url: "/api/promotion/rubriques"},
                  "getSousRubriques": {method: 'GET', isArray: true, url: "/api/promotion/sousRubriques"},
               "getAllVisiteContenu": {method: 'GET', isArray: true, url: "/api/visiteContenu/contenu/:contenuid"},
                  "getVisiteContenu": {method: 'GET', isArray: true, url: "/api/visiteContenu/user/:userid/contenu/:contenuid"},
           "getUserContenuByContenu": {method: 'GET', isArray: true, url: "/api/userContenu/user/contenu/:contenuid"},

                         "patchUser": {method: 'PATCH', url: "/api/users/:userid", userid: 'userid'},
                       "patchRating": {method: 'PATCH', url: "/api/rate"},
                  "patchUserContenu": {method: 'PATCH',  url: "/api/usercontenu/:userid/:contenuid"},
                     "patchQuestion": {method: 'PATCH',  url: "/api/lectureContenu/Questions/:questionid"},

                    "postAuthTokens": {method: 'POST', url: "/api/auth-tokens/:countClick"},
                      "postQuestion": {method: "POST", url: "/api/lectureContenu/:contenuid/:userid/:typequestionid/Questions"},
                       "postReponse": {method: "POST", url: "/api/lectureContenu/Question/:questionid/:userid/Reponses"},
                   "postCommentaire": {method: "POST", url: "/api/lectureContenu/Question/Reponse/:reponseid/:userid/Commentaires"},
                         "postCheck": {method: "POST", url: "/api/vote"},
                       "postInutile": {method: "POST", url: "/api/inutile"},
                         "postImage": {method: "POST", url: "/api/images"},
                     "postConteneur": {method: "POST", url: "/api/conteneur/:anneeid/:rubriqueid/:sousRubriqueid/:userid"},


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
                getUserVote: function (ref_id, ref, user_id) {
                        return apiData.getUserVote({refid: ref_id, ref: ref, userid: user_id });
                    },
                getRubriqueDashboard: function (user_id, num_rubrique) {
                            return apiData.getRubriqueDashboard({userid: user_id, numRubrique: num_rubrique});
                        },
                getUserReview: function (contenu_id, user_id) {
                    return apiData.getUserReview({contenuid: contenu_id, userid: user_id});
                       },
                getUserNote: function (contenu_id, user_id) {
                    return apiData.getUserNote({contenuid: contenu_id, userid: user_id});
                },
                getRubriques: function () {
                    return apiData.getRubriques();
                },
                getSousRubriques: function () {
                    return apiData.getSousRubriques();
                },
                getAllVisiteContenu: function (contenu_id) {
                    return apiData.getAllVisiteContenu({contenuid: contenu_id});
                },
                getVisiteContenu: function (contenu_id, user_id) {
                    return apiData.getVisiteContenu({contenuid: contenu_id, userid: user_id});
                },
                getUserContenuByContenu: function (contenu_id) {
                    return apiData.getUserContenuByContenu({contenuid: contenu_id});
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
                patchRating: function (voteData) {
                    apiData.patchRating(voteData, function() {
                        console.log("Success !");
                        return true;
                    }, function(error) {
                        console.log(error.data);
                    });
                },
                patchUserContenu: function (userContenuData, user_id, contenu_id) {
                    apiData.patchUserContenu({userid: user_id, contenuid: contenu_id}, userContenuData, function() {
                        console.log("Success !");
                        return true;
                    }, function(error) {
                        console.log(error.data);
                    });
                },
                patchQuestion: function (questionData, question_id) {
                    return apiData.patchQuestion({questionid: question_id}, questionData, function() {
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
                postImage: function(imageData) {
                    return apiData.postImage(imageData, function() {
                        console.log("Success !");
                        return true;
                    }, function(error) {
                        console.log(error.data);
                        return false;
                    });
                },
                postQuestion: function(question, contenu_id, user_id, type_question_id) {
                    var deferred = $q.defer();
                    apiData.postQuestion({contenuid: contenu_id, userid: user_id, typequestionid: type_question_id}, question, function(data) {
                        console.log("Success !");
                        deferred.resolve(data);

                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                        deferred.reject(error);
                    });
                    return deferred.promise;
                },
                postReponse: function(reponse, question_id, user_id) {
                    var deferred = $q.defer();
                    apiData.postReponse({questionid: question_id, userid: user_id}, reponse, function(data) {
                        console.log("Success !");
                        deferred.resolve(data);

                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                        deferred.reject(error);
                    });
                    return deferred.promise;
                },
                postCommentaire: function(commentaire, reponse_id, user_id) {
                    var deferred = $q.defer();
                    apiData.postCommentaire({reponseid: reponse_id, userid: user_id}, commentaire, function(data) {
                        console.log("Success !");
                        deferred.resolve(data);

                    }, function(error) {
                        console.log("Error " + error.status + " when sending request : " + error.data);
                        deferred.reject(error);
                    });
                    return deferred.promise;
                },
                postCheck: function(voteData) {
                    return apiData.postCheck( voteData, function(data) {
                        console.log("Success !");
                        return data;
                    }, function(error) {
                        console.log(error.data);
                        return false;
                    });
                },
              postInutile: function(inutileData) {
                    return apiData.postInutile( inutileData, function(data) {
                        console.log("Success !");
                        return data;
                    }, function(error) {
                        console.log(error.data);
                        return false;
                    });
                },
              postConteneur: function(contenu, annee_id, rubrique_id, sousRubrique_id, user_id ) {
                        return apiData.postConteneur( {anneeid: annee_id,  rubriqueid: rubrique_id, sousRubriqueid: sousRubrique_id, userid: user_id }, contenu, function() {
                            console.log("Success !");
                        }, function(error) {
                            console.log(error.data);
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