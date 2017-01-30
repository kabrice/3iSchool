angular.module("3ischool", ["ngSanitize", 'angular.filter', 'ui.tinymce', "ContenuServiceRest", "ngAnimate", 'ui.bootstrap', "ngDialog",
    "MesFiltres", "MesDirectives", "ngFileUpload", "ngImgCrop", "vcRecaptcha", "angular-click-outside", "ngRateIt"])
    .config(function($interpolateProvider, $httpProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

        $httpProvider.interceptors.push(function ($q, $rootScope, $window) {

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

                    if(motifRejet.status == 401) $window.location.href = '/';

                    if(--nbreReqs == 0){
                        $rootScope.chargementEnCours = false;
                    }
                    return $q.reject(motifRejet);
                }
            }
        })

    })
    .controller("3ischoolCtrl", function ($filter, $http,$rootScope , $window, $scope, $sce, $location,
                                          $interval, Upload, contenuService, vcRecaptchaService) {


        //Chargement En cours
        $rootScope.chargementEnCours =false;

        $rootScope.headers = null;

        $scope.rubriqueCourante = 'Tous';
        $scope.conteneurs = null;

        $scope.conteneurCourant = null;
        $scope.contenuRoot = null;
        $scope.showHome = false;
        $scope.logged = false;



        //Default values
        $scope.test = {
            rateit: 0
        }

        $scope.rate = function () {
            console.log($scope.test.rateit);
        }

        $scope.ecole = {
            anneeid: 3,
            groupeid: 2,
            niveauid: 3
        };

        if(localStorage.promotion != undefined)
        {
            $scope.ecole = angular.fromJson(localStorage.promotion);
        }

//selected value onload

        $scope.selectedValue = {
            userid: localStorage.userData,
            niveauid: $scope.ecole.niveauid.toString(),
            groupeid: $scope.ecole.groupeid.toString(),
            anneeid: $scope.ecole.anneeid.toString()

        };

        $scope.reload = function (){
            localStorage.promotion= angular.toJson($scope.selectedValue);
            console.log("test", $scope.ecole.anneeid);
            $window.location.href = '/'
        };

        // Recheche Contenu
        $scope.hideSearch = true;

        $scope.data = {
            rechercheContenu:null
        };


        $scope.selectionRubrique = function (rubriqueLibelle) {
            $scope.hideSearch = true;
            $scope.showAnnoncesImportantes = false;
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



        $scope.showProfil = true;


        $scope.getUser = function (email) {

            $scope.userProfil = contenuService.getUser(angular.fromJson(email));

            $scope.userProfil.$promise.then(function(){

                console.log($scope.userProfil[0].nom);
                console.log($scope.username);
            });
        }










        // Recherche Contenu

        $scope.showSearch = function()
        {
            $scope.hideSearch = false;
            $scope.showAnnoncesImportantes = false;
            // console.log($scope.data.rechercheContenu);
            if($scope.data.rechercheContenu == null || ($scope.data.rechercheContenu).length == 0)
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


        /*** *** *** *** ***III AUTHENTIFICATION  *** *** *** *** ***/

        $scope.showMAJPassword = false;
        $scope.showEmailError = false;
        $scope.showSuivant = true;
        $scope.showEmailCard = true;
        $scope.userID = null;
        $scope.isEmpty=null;
        $scope.showImageUpload = false;
        $scope.showImageSubmit = false;
        $scope.showAlmostDone = false;
        $scope.showCredentialsError=false;
        $scope.countClickConnexion = 0;
        $scope.show=false;
        $scope.showEnd = false;
        $scope.showErrorSameEmail = false;
        $scope.isPersonnel = false;
        $scope.showAnnoncesImportantes = false;

        $scope.loadHomePage = function (userid, anneeid, groupeid, niveauid) {
            //console.log("loadHomePage() showProfil", $scope.showProfil);


            $scope.showHome = true;
            $scope.showConnexion = false;

            if(localStorage.promotion != undefined)
            {
                $scope.promotion = angular.fromJson(localStorage.promotion);
                anneeid = parseInt($scope.promotion.anneeid);
                groupeid = parseInt($scope.promotion.groupeid);
                niveauid = parseInt($scope.promotion.niveauid);
            }

            console.log(userid, anneeid, groupeid, niveauid);

            //if(isNaN(anneeid) || isNaN(groupeid) || isNaN(niveauid)) return;
            $scope.groupesContenus = contenuService.getGroupesContenus(userid, anneeid, groupeid, niveauid);
            $scope.annees = contenuService.getAnnee();
            $scope.groupes = contenuService.getGroupe();
            $scope.niveaux = contenuService.getNiveau();

        }

        $scope.suivant = function(userEmail)
        {

            contenuService.isPasswordEmpty(userEmail).$promise.then(function(data) {

                if(data.isPasswordEmpty===true){

                    $scope.showMAJPassword = true;
                    $scope.showSuivant = false;
                    $scope.userID = data.userID;

                    if(data.isPersonnel)
                    {
                        $scope.isPersonnel = true;
                    }


                }else if(angular.equals(data.isPasswordEmpty, "incorrect")) {
                    $scope.showEmailError = true;
                }else{

                    $scope.showConnexion = true;
                    $scope.showSuivant = false;
                }

            });

        }

        $scope.connexion = function (userData) {

            console.log($scope.countClickConnexion);
            $scope.authToken = contenuService.postAuthTokens(userData,  $scope.countClickConnexion);

            $scope.authToken.$promise.then(function(){

                if($scope.authToken.credentials===false)
                {

                    $scope.showCredentialsError = true;
                    $scope.countClickConnexion++;
                    return;
                }

                console.log($scope.authToken);
                localStorage.userData= angular.toJson($scope.authToken);
                $scope.authToken = angular.fromJson(localStorage.userData);
                $http.defaults.headers.common["X-Auth-Token"] = $scope.authToken.value;

                $scope.loadHomePage($scope.authToken.user.id ,$scope.ecole.anneeid, $scope.ecole.groupeid, $scope.ecole.niveauid);

            });
        }


        $scope.signUp = function(user)
        {

            contenuService.patchUser(user, $scope.userID);
            $scope.showEnd = true;
            $scope.showAlmostDone = false;

        }

        $scope.logOut = function () {

            contenuService.deleteAuthToken($scope.authToken.id);
            delete localStorage.userData;
            delete localStorage.promotion;
            $window.location.href = '/';
        }



        /*** *** *** *** ***III-1 IMAGE HANDLE  *** *** *** *** ***/



        $scope.upload = function (imgData) {
            $scope.showImageSubmit = false;
            $scope.showAlmostDone = true;
            $scope.showImageCropped = true;
            $scope.image = imgData;
            console.log(imgData);
        }
        /*** *** *** *** ***III-2 RECAPTCHA  *** *** *** *** ***/







        /*** *** *** *** *** WATCHER  *** *** *** *** ***/

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

                    case "underConstruction":
                        $scope.showAnnoncesImportantes = true;
                        $scope.rubriqueCourante = null;
                        break;
                    default:
                    //console.log("WEIRD !")
                }

            }

        });




        if(localStorage.userData != undefined)
        {
            $scope.authToken = angular.fromJson(localStorage.userData);
            $http.defaults.headers.common["X-Auth-Token"] =  $scope.authToken.value;
            var userEmail = $scope.authToken.user.email;
            $scope.username= userEmail.substr(0, userEmail.indexOf('@'));
            console.log($scope.username);
            $scope.logged = true;
            $scope.loadHomePage($scope.authToken.user.id, $scope.ecole.anneeid, $scope.ecole.groupeid, $scope.ecole.niveauid);
        }


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
    }])

    .controller("lectureContenuCtrl", function ($scope, $filter,  $http, $sce,contenuService, ngDialog, $rootScope, $location) {

        $rootScope.chargementEnCours =false;

        $scope.idConteneurSelectionne = null;

        $scope.idQuestionSelectionnee = null;
        $scope.questionSelectionnee = null;
        $scope.conteneurCourant = null;
        // panel question
        $scope.questionFullscreen = false;
        $scope.questionDetailFullscreen = null;

        $scope.backToQuestion = function () {
            $scope.questionDetailFullscreen = null;
            $scope.afficherNewQuestion = false;
            //$scope.getConteneurByID($scope.idConteneurSelectionne);
        }

        $scope.displayQuestionDetail = function(id)
        {

            $scope.questionDetailFullscreen = $scope.questionFullscreen;
            $scope.idQuestionSelectionnee = id;
            $scope.getQuestionByID($scope.idQuestionSelectionnee);

        }

        // Création d'une question

        $scope.afficherNewQuestion = false;
        $scope.showQuestionError = false;

        $scope.publierQuestion = function(newQuestion)
        {

            contenuService.postQuestion(newQuestion, 1, 1, 1);
            $scope.afficherNewQuestion = false;
            $location.path("/");

        }

        $scope.getConteneurByID = function(id)
        {

            $scope.idConteneurSelectionne = id;




            contenuService.getConteneur(id).$promise.then(function(data){
                $scope.conteneurCourant = data;
                $scope.contenuRoot = $scope.conteneurCourant.contenu.contenuRoot;
                $scope.contenuURL = $sce.trustAsResourceUrl("https://docs.google.com/viewer?embedded=true&url=" + $scope.contenuRoot);
                $scope.sousRubriqueLibelle = $scope.conteneurCourant.contenu.sousRubrique.libelle;
                $scope.conteneurQuestion = $scope.conteneurCourant.contenu.questions;
            });
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

        $scope.displayQuestionOnMobile = function(){
            $scope.zoom();
        }




        $scope.clickToOpen = function () {
            ngDialog.open({ template: '/review', className: 'ngdialog-theme-default', controller: 'lectureContenuCtrl' });
        };

        $scope.closeThisDialog = function (review) {

            console.log(review);
            if(review==undefined || review.length<199) return;
            ngDialog.close();
        }

        if(localStorage.userData != undefined)
        {
            $scope.authToken = angular.fromJson(localStorage.userData);
            $http.defaults.headers.common["X-Auth-Token"] =  $scope.authToken.value;
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

    })
    .controller("forgotPasswordCtrl", function ($scope, contenuService) {

        $scope.showEmailError = false;
        $scope.showReset = true;
        $scope.showEnd = false;

        $scope.reset = function(userEmail)
        {
            $scope.showEmailError = false;
            contenuService.isPasswordEmpty(userEmail).$promise.then(function(data) {

                if(angular.equals(data.isPasswordEmpty, "incorrect")) {
                    $scope.showEmailError = true;
                }else{

                    $scope.showEnd = true;
                    $scope.showReset = false;
                }
            });
        }

    })
    .filter('start', function () {
        return function (input, start) {
            if (!input || !input.length) { return; }

            start = +start;
            return input.slice(start);
        };
    })
    .directive('toggleClass', function() {
        return {
            restrict: 'A',
            link: function(scope, element,  attrs) {
                element.bind('click', function() {
                    $("#wrapper").toggleClass(attrs.toggleClass);
                });
            }
        };
    });
