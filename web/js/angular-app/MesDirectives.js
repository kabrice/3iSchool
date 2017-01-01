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
            conteneur: "=",
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





