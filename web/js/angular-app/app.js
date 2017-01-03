angular.module("3ischool", ["ngSanitize", 'angular.filter', 'ui.tinymce', "ContenuServiceRest", "MesFiltres", "MesDirectives"])
    .config(function($interpolateProvider, $httpProvider){
         $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

         $httpProvider.interceptors.push(function ($q, $rootScope) {
             var nbreReqs = 0;
             return {
                 request: function (config) {
                     nbreReqs++;
                     $rootScope.chargementEnCours = true;
                     return config;
                 },
                 /*requestError: function (motifRejet) {
                     return $q.reject(motifRejet);
                 },*/
                 response: function (reponse) {
                     if(--nbreReqs == 0){
                         $rootScope.chargementEnCours = false;
                     }
                     return reponse;
                 },
                 responseError: function (motifRejet) {
                     if(--nbreReqs == 0){
                         $rootScope.chargementEnCours = false;
                     }
                     return $q.reject(motifRejet);
                 }
             }
         })

    })
    .controller("3ischoolCtrl",function ($filter,$http,$rootScope, $window, $scope, $sce, $location, $interval, contenuService) {


       //Chargement En cours
        $rootScope.chargementEnCours =false;

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

        $scope.isNullOrEmptyOrUndefined = function (value) {
            return !value;
        }

        $scope.getConteneurByID = function(id)
        {

                $scope.idConteneurSelectionne = id;


                $scope.conteneurCourant = contenuService.getConteneur(id);

                $scope.conteneurCourant.$promise.then(function(){
                    $scope.contenuRoot = $scope.conteneurCourant.contenu.contenuRoot;
                    $scope.contenuURL = $sce.trustAsResourceUrl("https://docs.google.com/viewer?embedded=true&url=" + $scope.contenuRoot);
                    $scope.sousRubriqueLibelle = $scope.conteneurCourant.contenu.sousRubrique.libelle;
                    $scope.conteneurQuestion = $scope.conteneurCourant.contenu.questions;
                });



        }



        $scope.displayQuestionDetail = function(id)
        {

            $scope.questionDetailFullscreen = $scope.questionFullscreen;
            $scope.idQuestionSelectionnee = id;
            $scope.getQuestionByID($scope.idQuestionSelectionnee);

        }

        $scope.getQuestionByID = function(idQuestion)
        {
            $scope.conteneurCourant.$promise.then(function(){
                $scope.questionSelectionnee = $filter('filter')($scope.conteneurCourant.contenu.questions, function (d) {
                    return d.id === idQuestion;
                })[0];
            });

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
            //$scope.getConteneurByID($scope.idConteneurSelectionne);
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

            contenuService.postQuestion(newQuestion, 1, 1, 1);
            $scope.afficherNewQuestion = false;
            $location.path("/");

        }

                                                                            /*** *** *** *** *** AUTHENTIFICATION  *** *** *** *** ***/

         $scope.showMAJPassword = false;
         $scope.showEmailError = false;
         $scope.showConnexion = false;
         $scope.showEmailCard = true;

        $scope.connexion = function(userEmail)
        {
            //console.log(contenuService.isPasswordEmpty(userEmail));
           contenuService.isPasswordEmpty(userEmail).$promise.then(function() {
               var isEmpty = contenuService.isPasswordEmpty(userEmail);
                if(isEmpty){
                    $scope.showMAJPassword = true;
                    $scope.showEmailCard = true;
                }else if(isEmpty=="incorrect") {
                   $scope.showEmailError = true;
                }else{
                    $scope.showConnexion = true;
                    $scope.showEmailCard = true;
                }
            });
        }

        $scope.majPassword = function(user)
        {

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

                        $scope.groupesContenus.$promise.then(function(){
                            $scope.groupesContenus.CONTENEUR.forEach(function (unConteneur) {
                                if(unConteneur.libelle_rubrique==rubrique){
                                    $scope.selectionRubrique(rubrique);
                                }
                            })
                        });


                        break;
                    case 'enseignants':
                        var enseignantNom = tabPath[2];

                        $scope.groupesContenus.$promise.then(function(){
                            $scope.groupesContenus.CONTENEUR.forEach(function (unConteneur) {
                                if(unConteneur.nom==enseignantNom){
                                    $scope.selectionRubrique(enseignantNom);
                                }
                            })
                        });


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
                       // $scope.conteneurCourant = null;
                        break;
                    default:
                    //console.log("WEIRD !")
                }

            }

        });


         $scope.groupesContenus = contenuService.getGroupesContenus(1,3,2,3);
         $scope.annees = contenuService.getAnnee();
         $scope.groupes = contenuService.getGroupe();
         $scope.niveaux = contenuService.getNiveau();

         //$scope.groupesContenus = contenuService.getGroupesContenus();
        //console.log($scope.conteneurCourant2.contenu);

    })

    .directive("owlCarousel", function() {
        return {
            restrict: 'E',
            transclude: false,
            link: function (scope) {
                scope.initCarousel = function(element) {
                    // provide any default options you want
                    var defaultOptions =
                    {
                        items: 5,
                        itemsCustom: false,
                        itemsDesktop: [1399, 4],
                        itemsDesktopSmall: [1100, 3],
                        itemsTablet: [930, 2],
                        itemsTabletSmall: false,
                        itemsMobile: [479, 1],
                        singleItem: false,
                        itemsScaleUp: false,
                        slideSpeed: 200,
                        paginationSpeed: 800,
                        rewindSpeed: 1000,
                        autoPlay: true,
                        autoWeight: false,
                        autoHeight: false
                    };
                    var customOptions = scope.$eval($(element).attr('data-options'));
                    // combine the two options objects
                    for(var key in customOptions) {
                        defaultOptions[key] = customOptions[key];
                    }
                    // init carousel
                    $(element).owlCarousel(defaultOptions);
                };
            }
        };
    })
    .directive('owlCarouselItem', [function() {
        return {
            restrict: 'A',
            transclude: false,
            link: function(scope, element) {
                // wait for the last item in the ng-repeat then call init
                if(scope.$last) {
                    scope.initCarousel(element.parent());
                }
            }
        };
    }]);