angular.module("MesDirectives", ['angular.filter', "MesFiltres"])
.directive("contenusRubrique", function () {

    return {
        //A attribut
        //E element (balise)
        //C css classe
        //M Comment

        restrict: "E",
        templateUrl: '/contenusRubrique',
        replace: true,
        scope: {
            contenu: "=",
            recherche: "="
        }

    }
})
.directive("contenusTries", function () {

    return {
        restrict: "E",
        templateUrl: '/contenusTries',
        replace: true,
        scope: {
            contenu: "="
        }
    }
})
.directive("newQuestion", function () {
    return {
        restrict: "E",
        templateUrl: '/newQuestion',
        replace: true,
        scope: {
            fullscreen: '=',
            showError: '=',
            ssRubriqueLibelle: '=',
            publierQuestion: '&'
        },
        controller: function ($scope, $location, $anchorScroll) {

            $scope.initNewQuestion = function () {
                $scope.newQuestion = {

                    "page": 1000,
                    "ligne": 1000
                };
            }

            $scope.optionTinyMCE = {
                language: "fr_FR",
                selector: "textarea",
                  height: 680,
                statusbar: false,
                menubar: false,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

            };


            $scope.clicPublierQuestion = function () {
                var libelleQuestion = $scope.newQuestion.libelle;
                //$scope.showQuestionError = false;
                if(!libelleQuestion || !(libelleQuestion.substr(-1) === "?")
                                        || libelleQuestion.length>=150)
                {
                    $scope.showQuestionError=!$scope.showQuestionError;
                    $location.hash('bottom');
                    $anchorScroll();
                    return;
                }
                if(!$scope.newQuestion.description)
                {
                    if (!window.confirm("Confirmation\n\nÊtes-vous certain de vouloir publier une question sans description ?")) {
                        return;
                    }
                }


                $scope.publierQuestion({newQuestion : $scope.newQuestion});
            }
            $scope.initNewQuestion();
            //Creation d'évènement en AngularJS
            $scope.$on("initNewQuestion", function () {
                $scope.initNewQuestion();
            })

        }
    }
})

    .directive("authentification", function () {
        return {
            restrict: "E",
            templateUrl: '/authentification',
            replace: true,
            scope: {
                showMAJPassword: '=',
                 showEmailError: '=',
                  showConnexion: '=',
                  showEmailCard: '=',
                      connexion: '&',
                    majPassword: '&'
            },
            controller: function ($scope) {

                $scope.showErrorLongPassword = false;
                $scope.showErrorShortPassword = false;
                $scope.user = {
                    email: null
                }
                $scope.clicConnexion= function () {
                    var regExpValidEmail = new RegExp("^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$", "gi");
                    if($scope.user.email == null) return;
                    if (!$scope.user.email || !$scope.user.email.match(regExpValidEmail)) {
                        //console.log("ok");
                        console.log("Erreur\n\nMerci de vérifier l'adresse e-mail saisie.");
                        return;
                    }

                    $scope.suivant({userEmail : $scope.user.email});
                }

                $scope.clicMAJPassword = function(){
                    if(user.plainPassword.length<8) {
                        $scope.showErrorShortPassword = true;
                    }else if(user.plainPassword.length>50) {
                        $scope.showErrorLongPassword = true;
                    }

                }

            }
        }
    })

.directive("listeQuestions", function () {
    return {
        restrict: "E",
        templateUrl: '/listeQuestions',
        replace: true,
        scope: {
            questions: "="
        }
    }
})



.directive("commentairesReponse", function () {
    return {
        restrict: "A",
        templateUrl: '/commentairesReponse',
        replace: true,
        scope: {
            comment: "=",
            answer: "="
        }
    }
})





