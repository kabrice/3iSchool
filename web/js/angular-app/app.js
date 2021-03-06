var app = angular.module("3ischool", ["ngSanitize", 'angular.filter', 'ui.tinymce', "ContenuServiceRest", "ngAnimate", "chart.js",
                         "ui.bootstrap", "ngDialog", "MesFiltres", "MesDirectives", "ngFileUpload", "ngImgCrop", "vcRecaptcha",
                         "angular-click-outside", "ngRateIt", "DashboardDirectives", 'ui.select',  'angular-thumbnails'])

    .config(function($interpolateProvider, $httpProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');



        $httpProvider.interceptors.push(function ($q, $rootScope, $window) {

            var nbreReqs = 0;
            return {
                request: function (config) {
                    nbreReqs++;
                    if($rootScope.blockLoading != undefined && $rootScope.blockLoading)
                    {
                        $rootScope.chargementEnCours = false;
                        $rootScope.chargementNouveauContenu = false;
                        $rootScope.chargementRubrique = true;
                    }else {
                        $rootScope.chargementEnCours = true;
                        $rootScope.chargementNouveauContenu = true;
                    }
                    return config;
                },
                /*requestError: function (motifRejet) {
                 return $q.reject(motifRejet);
                 },*/
                response: function (reponse) {
                    if(--nbreReqs == 0){
                        $rootScope.chargementEnCours = false;
                        $rootScope.chargementNouveauContenu = false;
                        $rootScope.chargementRubrique = false;
                    }
                    return reponse;
                },
                responseError: function (motifRejet) {

                    if(motifRejet.status == 401) $window.location.href = '/';

                    if(--nbreReqs == 0){
                        $rootScope.chargementEnCours = false;
                        $rootScope.chargementNouveauContenu = false;
                        $rootScope.chargementRubrique = false;
                    }

                    return $q.reject(motifRejet);
                }
            }
        })

    })
    .controller("3ischoolCtrl", function ($filter, $http,$rootScope , $window, $scope, $sce, $location,
                                          $interval, Upload, contenuService, vcRecaptchaService, $uibModal,$uibModalStack) {


        //Chargement En cours
        $rootScope.chargementEnCours =false;
        $rootScope.blockLoading = false;
        $rootScope.headers = null;
        $rootScope.chargementRubrique = false;
        $scope.rubriqueCourante = 'Tous';
        $scope.conteneurs = null;

        $scope.conteneurCourant = null;
        $scope.contenuRoot = null;
        $scope.showHome = false;
        $scope.logged = false;




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

            if($scope.authToken.user.isPersonnel)
            {
                localStorage.promotion = angular.toJson($scope.selectedValue);
                $window.location.href = '/'
            }else {

                contenuService.patchPromotionNotification({}, localStorage.promotionNotificationID, $scope.selectedValue.anneeid,
                    $scope.selectedValue.groupeid,
                    $scope.selectedValue.niveauid,
                    angular.fromJson(localStorage.userData).user.id).$promise.then(function () {


                    localStorage.promotion = angular.toJson($scope.selectedValue);
                    $window.location.href = '/'

                }, function (error) {
                    console.log(error);
                });
            }

        };

        // Recheche Contenu
        $scope.hideSearch = true;

        $scope.data = {
            rechercheContenu:null
        };

        $scope.isEnseignant = false;
        $scope.selectionRubrique = function (rubriqueLibelle) {
            $scope.hideSearch = true;
            $scope.showAnnoncesImportantes = false;

            $scope.rubriqueCourante = rubriqueLibelle;
            if($scope.rubriqueCourante != 'Tous') {

                $rootScope.chargementRubrique = true;
                $rootScope.blockLoading = true;

                contenuService.getConteneurByRubrique($scope.isEnseignant, rubriqueLibelle,
                    $scope.ecole.anneeid, $scope.ecole.groupeid, $scope.ecole.niveauid).$promise.then(function (data) {
                    $scope.conteneurs = data;
                }, function (error) {
                    console.log(error);
                })

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

        //File management

        $scope.setFileEventListener = function(element) {
            $scope.uploadedFile = element.files[0];

            if ($scope.uploadedFile) {
                $scope.$apply(function() {
                    $scope.upload_button_state = true;
                });
            }
        }

        $scope.uploadFile = function() {
            uploadFile();
        };


        function uploadFile() {
            if (!$scope.uploadedFile) {
                return;
            }

          console.log($scope.uploadedFile);
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
        $scope.showErrorNom = false;
        $scope.isPersonnel = false;
        $scope.showAnnoncesImportantes = false;

        $scope.currentPage = 1; // keeps track of the current page
        $scope.pageSize = 15; // holds the number of items per page

        $scope.loadHomePage = function (userid, anneeid, groupeid, niveauid) {


            if(sessionStorage.goToDashboard != undefined)
            {
                console.log("ok");
                $window.location.href = 'http://www.3ilcours.fr/dashboard';
                delete sessionStorage.goToDashboard;
            }

            $scope.showHome = true;
            $scope.showConnexion = false;

            if(localStorage.promotion != undefined)
            {
                $scope.promotion = angular.fromJson(localStorage.promotion);
                anneeid = parseInt($scope.promotion.anneeid);
                groupeid = parseInt($scope.promotion.groupeid);
                niveauid = parseInt($scope.promotion.niveauid);
            }/*else {
                return;
            }*/
            console.log(userid, anneeid, groupeid, niveauid);

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

                if($scope.authToken.activated===false)
                {

                    $scope.showNoActivatedError = true;
                    $scope.countClickConnexion++;
                    return;
                }

                console.log($scope.authToken);
                localStorage.userData= angular.toJson($scope.authToken);
                $scope.authToken = angular.fromJson(localStorage.userData);
                $http.defaults.headers.common["X-Auth-Token"] = $scope.authToken.value;
                console.log("localStorage.userData", localStorage.userData);
                if($scope.authToken.user.isPersonnel)
                {
                    sessionStorage.goToDashboard = true;
                    $window.location.href = 'http://www.3ilcours.fr/dashboard';

                }else{

                    contenuService.getPromotionNotification($scope.authToken.user.id).$promise.then(function (data) {
                        if(data.id==0)
                        {
                            $scope.optionModal = $uibModal.open({
                             backdrop  : 'static',
                             keyboard  : false,
                             templateUrl: '/modalPromotionNotification',
                             controller: 'ModalPromotionNotification'
                             });

                        }else{

                            $scope.ecole = {
                                anneeid: parseInt(data.annee.id),
                                groupeid: parseInt(data.groupe.id),
                                niveauid: parseInt(data.niveau.id)
                            };
                            console.log(data.id);
                            localStorage.promotionNotificationID = data.id;
                            console.log("ecole", $scope.ecole);

                        }

                        $scope.selectedValue = {
                            userid: localStorage.userData,
                            niveauid: $scope.ecole.niveauid.toString(),
                            groupeid: $scope.ecole.groupeid.toString(),
                            anneeid: $scope.ecole.anneeid.toString()

                        };
                        console.log($scope.authToken.user.id ,$scope.ecole.anneeid, $scope.ecole.groupeid, $scope.ecole.niveauid);
                        $scope.loadHomePage($scope.authToken.user.id ,$scope.ecole.anneeid, $scope.ecole.groupeid, $scope.ecole.niveauid);

                    }, function (error) {
                        console.log(error)
                    })

                }

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
            delete localStorage.promotionNotificationID;
            $window.location.href = '/';

        }



        /*** *** *** *** ***III-1 IMAGE HANDLE  *** *** *** *** ***/

        $scope.bfiConfig = {
            showUpload: false,
            previewFileType: 'any'
        }

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
                        $scope.isEnseignant = false;
                        var rubrique = tabPath[2];
                        $scope.selectionRubrique(rubrique);
                       /* $scope.groupesContenus.$promise.then(function(){
                            $scope.groupesContenus.CONTENEUR.forEach(function (unConteneur) {
                                if(unConteneur.libelle_rubrique==rubrique){
                                    $scope.selectionRubrique(rubrique);
                                }
                            })
                        });*/
                        break;

                    case 'enseignants':
                        var enseignantNom = tabPath[2];
                        $scope.isEnseignant = true;
                        $scope.selectionRubrique(enseignantNom);
                        /*$scope.groupesContenus.$promise.then(function(){
                            $scope.groupesContenus.CONTENEUR.forEach(function (unConteneur) {
                                if(unConteneur.nom==enseignantNom){
                                    $scope.selectionRubrique(enseignantNom);
                                }
                            })
                        });*/
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


        if(sessionStorage.validationSuccess != undefined)
        {
            $scope.validationSuccess = angular.fromJson(sessionStorage.validationSuccess);
            delete sessionStorage.validationSuccess;
        }
        //console.log(localStorage.userData);
        if(localStorage.userData != undefined)
        {
            console.log(localStorage.userData != undefined);
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

app.controller("ModalPromotionNotification", function ($uibModal,$uibModalStack, $scope, contenuService, $window) {

    $scope.ecole = {
        anneeid: 2,
        groupeid: 2,
        niveauid: 2
    };

    $scope.annees = contenuService.getAnnee();
    $scope.groupes = contenuService.getGroupe();
    $scope.niveaux = contenuService.getNiveau();

    $scope.selectedValue = {
        userid: localStorage.userData,
        niveauid: $scope.ecole.niveauid.toString(),
        groupeid: $scope.ecole.groupeid.toString(),
        anneeid: $scope.ecole.anneeid.toString()

    };




     $scope.valider = function() {
     contenuService.postPromotionNotification({}, $scope.selectedValue.anneeid,
     $scope.selectedValue.groupeid,
     $scope.selectedValue.niveauid,
     angular.fromJson($scope.selectedValue.userid).user.id).$promise.then(function (data) {
         localStorage.promotionNotificationID = data.id;
         localStorage.promotion= angular.toJson($scope.selectedValue);
         $window.location.href = '/'

     }, function (error) {
     console.log(error);
     });
         $uibModalStack.dismissAll();

     }

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


    .controller("forgotPasswordCtrl", function ($scope, contenuService, $window) {

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
                    contenuService.patchResetPassword(userEmail).$promise.then(function (data) {
                        console.log("success");
                    }, function (error) {
                        $window.location.href = '/';
                    })
                    $scope.showEnd = true;
                    $scope.showReset = false;
                }
            });
        }

        $scope.showErrorShortPassword = false;
        $scope.showErrorLongPassword = false;
        $scope.showErrorNotSame = false;
        $scope.temp = {
            email: null,
            confirmPlainPassword:null
        };
        $scope.user = {
            plainPassword:null

        }

        $scope.validationCode = null;
        $scope.majPassword = function(){


            if($scope.user.plainPassword.length<8) {
                // if($scope.i<2)
                $scope.showErrorShortPassword = true;
                console.log($scope.showErrorShortPassword);
                return;
            }else if($scope.user.plainPassword.length>50) {
                $scope.showErrorLongPassword = true;
                return;
            }

            if(!angular.equals($scope.user.plainPassword, $scope.temp.confirmPlainPassword))
            {
               $scope.showErrorNotSame = true;
                return;
            }
           // console.log($scope.user, $scope.temp.userID);
            contenuService.patchUser($scope.user, $scope.temp.userID).$promise.then(function () {

                var validationData = {
                    userID: $scope.temp.userID,
                    validationCode: $scope.validationCode
                }

                contenuService.patchUserActivation(validationData).$promise.then(function (data) {

                    sessionStorage.validationSuccess = true;

                }, function (error) {
                    $window.location.href = '/';
                    console.log(error);
                })

                $window.location.href = '/';
            }, function () {
                $window.location.href = '/';
            })
            //console.log($scope.user);


        }

        $scope.rightToReset = function (userID, validationCode) {
            contenuService.getUserByCode(userID, angular.fromJson(validationCode)).$promise.then(function (data) {
                $scope.temp.email = data.email;
                $scope.temp.userID = data.id;
                $scope.validationCode = angular.fromJson(validationCode);
                delete localStorage.userData;
            }, function (error) {
                console.log(error);
                $window.location.href = '/';
            })
        }

    })

    .controller("VerifyCtrl", function ($scope, $window, contenuService) {



        $scope.activateAccount = function(userID, validationCode)
        {
            console.log(userID, angular.fromJson(validationCode));
            var validationData = {
                userID: userID,
                validationCode: angular.fromJson(validationCode)
            }
            contenuService.patchUserActivation(validationData).$promise.then(function (data) {

                delete localStorage.userData;
                sessionStorage.validationSuccess = true;
                $window.location.href = '/';

            }, function (error) {
                $window.location.href = '/';
                console.log(error);
            })
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
    })

    .directive("fileread", [function () {
        return {
            scope: {
                fileread: "="
            },
            link: function (scope, element, attributes) {
                element.bind("change", function (changeEvent) {
                    scope.$apply(function () {
                        scope.fileread = changeEvent.target.files[0];
                    });
                });
            }
        }
    }])



    .directive('ngPrism',['$interpolate', function ($interpolate) {
    "use strict";
    return {
        restrict: 'E',
        template: '<pre><code ng-transclude></code></pre>',
        replace: true,
        transclude: true,
        link: function (scope, elm) {
            var tmp = $interpolate(elm.find('code').text())(scope);
            elm.find('code').html(Prism.highlightElement(tmp).value);
        }
    };
}]);
