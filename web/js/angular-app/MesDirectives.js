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
            conteneur: "="
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
            publierQuestion: '&'
        },
        controller: function ($scope, $location, $anchorScroll) {

            $scope.initNewQuestion = function () {
                $scope.newQuestion = {
                    "libelle": "How to get Webpack, Wordpress, and BrowserSync to work together?",
                    "description": "<p class='qtext_para'>Subscibe to philosophy youtube channels, read books, watch good movies and art so you can intepret them.</p><p class='qtext_para'><b>But most important, become analytical.</b></p><p class='qtext_para'>Analyze your daily conversations and reactions with people,</p><p class='qtext_para'>¨Why did I say that¨</p><p class='qtext_para'>¨why did I do that¨</p><p class='qtext_para'>¨What are their motivations behind that action¨</p><p class='qtext_para'><b>At least this has worked for me.</b></p>",
                    "datePublication": new Date(),
                    "nombreLike": 5,
                    "nombreDislike": 18,
                    "page": 100,
                    "ligne": 10,
                    "report": 0,
                    "typeQuestion": {
                        "id": 1,
                        "libelle": "Contenu"
                    },
                    "users": [
                        {
                            "id": 9,
                            "email": "granet@3il.fr",
                            "nom": "Granet",
                            "prenom": "Catherine ",
                            "userProfilRoot": "img/granet.png",
                            "dateCreation": "2016-12-21T01:40:45+00:00",
                            "isBDE": false,
                            "isPersonnel": true
                        }
                    ],
                    "reponses": []
                };
            }

            $scope.optionTinyMCE = {
                language: "fr_FR",
                selector: "textarea",
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
                $scope.showQuestionError = false;
                if(!libelleQuestion || !(libelleQuestion.substr(-1) === "?") || libelleQuestion.length>=150 )
                {
                    $scope.showQuestionError = !$scope.showQuestionError;

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
