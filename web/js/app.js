angular.module("3ischool", ["ngSanitize", 'angular.filter', 'ui.tinymce', "ContenusGroupesServiceMock"])
    .config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

    })



    .controller("3ischoolCtrl",function ($filter, $window, $scope, $sce, $location, $interval, $anchorScroll, contenusGroupesService) {



        //$scope.trustAsHtml = $sce.trustAsHtml;

        $scope.rubriqueCourante = 'Tous';
        $scope.conteneurs = null;
        $scope.idConteneurSelectionne = null;
        $scope.conteneurCourant = null;
        $scope.contenuRoot = null;

        $scope.idQuestionSelectionnee = null;
        $scope.questionSelectionnee = null;

        // panel question
        $scope.questionFullscreen = false;
        $scope.questionDetailFullscreen = null;

        // Recheche Contenu
        $scope.hideSearch = true;
        $scope.rechercheContenu = null;

        $scope.nextQuestion=5;

        $scope.selectionRubrique = function (rubriqueLibelle) {
            $scope.hideSearch = true;
            $scope.rubriqueCourante = rubriqueLibelle;
            if($scope.rubriqueCourante != 'Tous') {
                $scope.conteneurs = $scope.groupesContenus.CONTENEUR;
            }else{
                $scope.conteneurs = null;
            }
        };


        $scope.getConteneurByID = function(id)
        {

                $scope.idConteneurSelectionne = id;

                // l'array à filtrer est $scope.groupesContenus.CONTENEUR
                // Le paramètre du filtre est la function qui suit
                $scope.conteneurCourant = $filter('filter')($scope.groupesContenus.CONTENEUR, function (d) {
                    return d.id === $scope.idConteneurSelectionne;
                })[0];
                $scope.contenuRoot = $scope.conteneurCourant.contenu.contenuRoot;
                $scope.contenuURL = $sce.trustAsResourceUrl("https://docs.google.com/viewer?embedded=true&url=" + $scope.contenuRoot);

            //Just test
            //$scope.displayQuestionDetail(1);
                $scope.sousRubriqueLibelle = $scope.conteneurCourant.contenu.sousRubrique.libelle;
            //console.log($scope.conteneurCourant.contenu.sousRubrique.libelle);
            //console.log($scope.groupesContenus.CONTENEUR);
        }

        $scope.displayQuestionDetail = function(id)
        {

            $scope.questionDetailFullscreen = $scope.questionFullscreen;
            $scope.idQuestionSelectionnee = id;
            $scope.getQuestionByID($scope.idQuestionSelectionnee);

        }

        $scope.getQuestionByID = function(idQuestion)
        {
            $scope.questionSelectionnee = $filter('filter')($scope.conteneurCourant.contenu.questions, function (d) {
                return d.id === idQuestion;
            })[0]; 
            //console.log("getQuestionByID "+$scope.questionSelectionnee);
            return ($scope.questionSelectionnee!=undefined);
        }

        $scope.zoom = function()
        {
            $scope.questionFullscreen = !$scope.questionFullscreen;

            if($scope.questionDetailFullscreen != null)
            {
                $scope.questionDetailFullscreen = !$scope.questionDetailFullscreen;
            }

        }

        $scope.backToQuestion = function () {
            $scope.questionDetailFullscreen = null;
            $scope.newQuestion=null;
            $scope.getConteneurByID($scope.idConteneurSelectionne);
        }

        $scope.displayQuestionOnMobile = function(){
            $scope.zoom();
        }

        // Recherche Contenu

        $scope.showSearch = function()
        {
            $scope.hideSearch = false;

           //console.log($scope.rechercheContenu);
            if($scope.rechercheContenu == null || ($scope.rechercheContenu).length == 0)
            {
                //console.log('empty');
                $scope.hideSearch = true;
            }

        }

        //Todo A faire plutard par rapport au resize de la homepage
        var checkActiveClass = function(){
            if(angular.element("#wrapper").hasClass("active"))
            {
                ///console.log("yes");
            }else{
               // console.log("no");
            }
        };

        $interval(checkActiveClass, 1000);

        // Filtre de recherche de contenu
       /* $scope.filtrerContenusRecherche = function()
        {
            return $filter("filter")($scope.groupesContenus.CONTENEUR, $scope.rechercheContenu);
        }*/

       // Création d'une question

        $scope.newQuestion = null;
        $scope.showQuestionError = false

        $scope.publierQuestion = function()
        {
            var libelleQuestion = $scope.newQuestion.libelle;
            if(!libelleQuestion || !(libelleQuestion.substr(-1) === "?") || libelleQuestion.length<=150 )
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

            $scope.newQuestion.id = $scope.nextQuestion++;
            $scope.getConteneurByID($scope.idConteneurSelectionne);
            //console.log($scope.conteneurCourant);
            ($scope.conteneurCourant.contenu.questions).push($scope.newQuestion);

            $scope.newQuestion = null;

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


        $scope.$watch(function(){
            return $location.path();
        }, function (newPath) {

            var tabPath = newPath.split("/");
            if(tabPath.length>1)
            {
                var categorie = tabPath[1];
                //console.log(categorie);

                switch(categorie) {
                    case 'rubriques':
                        var rubrique = tabPath[2];
                        $scope.groupesContenus.CONTENEUR.forEach(function (unConteneur) {
                            if(unConteneur.contenu.rubrique.libelle==rubrique){
                                $scope.selectionRubrique(rubrique);
                            }
                        })
                        break;
                    case "questions":
                        var idQuestion = parseInt(tabPath[2]);
                        console.log("questions");
                        if($scope.getQuestionByID(idQuestion)) {
                            $scope.displayQuestionDetail(idQuestion);
                        }else{
                            $scope.questionDetailFullscreen = null;
                        }
                        break;
                    case "back":
                        $scope.backToQuestion();
                        break;
                    case "newQuestion":

                        $scope.conteneurCourant = null;

                        //console.log("newQuestion");
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
                        break;
                    default:
                    //console.log("WEIRD !")
                }

            }

        });

        $scope.groupesContenus = contenusGroupesService.getGroupesContenus();

    })

    .filter("surbrillanceRecherche", function(){
        return function (input, recherche) {
            if(recherche){
                return input.replace(new RegExp("("+recherche+")", "gi"), "<span class='surbrillanceRecherche'>$1</span>");
            }
            return input;
        }
    });