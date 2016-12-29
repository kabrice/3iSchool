angular.module("3ischool", ["ngSanitize", 'angular.filter', 'ui.tinymce', "ContenusGroupesServiceMock", "MesFiltres", "MesDirectives"])
    .config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

    })



    .controller("3ischoolCtrl",function ($filter, $window, $scope, $sce, $location, $interval, contenusGroupesService) {



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
                $scope.conteneurCourant = contenusGroupesService.getConteneur($scope.groupesContenus.CONTENEUR, id);
                $scope.contenuRoot = $scope.conteneurCourant.contenu.contenuRoot;
                $scope.contenuURL = $sce.trustAsResourceUrl("https://docs.google.com/viewer?embedded=true&url=" + $scope.contenuRoot);
                $scope.sousRubriqueLibelle = $scope.conteneurCourant.contenu.sousRubrique.libelle;

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
            $scope.afficherNewQuestion = false;
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

        $scope.afficherNewQuestion = false;
        $scope.showQuestionError = false;

        $scope.publierQuestion = function(newQuestion)
        {

            $scope.getConteneurByID($scope.idConteneurSelectionne);
            contenusGroupesService.postQuestion($scope.conteneurCourant.contenu.questions, newQuestion);
            $scope.afficherNewQuestion = false;
            $location.path("/");

        }







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
                        $scope.afficherNewQuestion = true;
                        $scope.$broadcast("initNewQuestion");
                        $scope.conteneurCourant = null;
                        break;
                    default:
                    //console.log("WEIRD !")
                }

            }

        });

        $scope.groupesContenus = contenusGroupesService.getGroupesContenus();



    })

