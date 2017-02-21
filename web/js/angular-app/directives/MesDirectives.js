angular.module("MesDirectives", ['angular.filter', "MesFiltres", "vcRecaptcha"])
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
        controller: function ($scope, $location, $anchorScroll, $sce) {

            $scope.initNewQuestion = function () {
                $scope.newQuestion = {

                    "page": 0,
                    "ligne": 0
                };
            }

            $scope.optionTinyMCE = {
                language: "fr_FR",
                selector: "textarea",
                  height: 200,
                resize: "height",
                theme: 'modern',
                max_width: 400,
                menubar: false,
                statusbar: false,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks codesample fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ],

                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image codesample",

                codesample_languages: [
                    {text: 'HTML/XML', value: 'markup'},
                    {text: 'JavaScript', value: 'javascript'},
                    {text: 'CSS', value: 'css'},
                    {text: 'PHP', value: 'php'},
                    {text: 'Ruby', value: 'ruby'},
                    {text: 'Python', value: 'python'},
                    {text: 'Java', value: 'java'},
                    {text: 'C', value: 'c'},
                    {text: 'C#', value: 'csharp'},
                    {text: 'C++', value: 'cpp'}
                ],
                file_picker_types: 'image',
                file_picker_callback: function(callback, value, meta) {
                    if (meta.filetype == 'image') {
                        $('#upload').trigger('click');
                        $('#upload').on('change', function() {
                            console.log(value);
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onload = function(e) {

                                callback(e.target.result, {
                                    alt: ''
                                });
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                },
                templates: [{
                    title: 'Test template 1',
                    content: 'Test 1'
                }, {
                    title: 'Test template 2',
                    content: 'Test 2'
                }]


            };

            $scope.prism = function () {
                Prism.highlightAll();
                return true;
            }

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
                    if (!window.confirm("Êtes-vous certain de vouloir publier une question sans description ?")) {
                        return;
                    }
                }
                var tempDescription = htmlToPlaintext($scope.newQuestion.description);

                if(tempDescription.length<50)
                {
                    alert("Decription de la question trop courte !");
                    return
                }

                if($scope.newQuestion.page<999 && $scope.newQuestion.page>=1 && $scope.newQuestion.ligne<999 && $scope.newQuestion.ligne>=1)
                {

                    $scope.publierQuestion({newQuestion : $scope.newQuestion});
                   // $scope.newQuestion.description = null;

                }else{
                    window.alert("Veuillez renseigner un numéro de page ou de ligne valide (entre 1 et 999) !");
                    return;
                }

                //console.log($scope.newQuestion);

            }

            function htmlToPlaintext(text) {
                return text ? String(text).replace(/<[^>]+>/gm, '') : '';
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
                    showSuivant: '=',
                  showEmailCard: '=',
                showImageUpload: '=',

           showCredentialsError: '=',
             showErrorSameEmail: '=',
                showImageSubmit: '=',
                 showAlmostDone: '=',
                  showConnexion: '=',
              chargementEnCours: '=',
            countClickConnexion: '=',
                    isPersonnel: '=',
                          image: '=',
                       progress: '=',
                       errorMsg: '=',
               showImageCropped: '=',
                        showEnd: '=',
                        suivant: '&',
                         upload: '&',
                         signUp: '&',
                      connexion: '&',
                     ajoutPhoto: '&',
                    importPhoto: '&'

            },
            controller: function ($scope, vcRecaptchaService) {
                $scope.showErrorShortPassword = false;
                $scope.showErrorLongPassword = false;

                $scope.temp = {
                    email: null,

                };
                $scope.user = {
                    plainPassword:null,
                    emailPersonnel:null
                }
                $scope.clicSuivant= function () {

                    $scope.showEmailError = false;
                    var regExpValidEmail = new RegExp("^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$", "gi");
                    if($scope.temp.email == null) return;

                    if (!$scope.temp.email || !$scope.temp.email.match(regExpValidEmail)) {
                        //console.log("ok");
                        alert("Erreur\n\nMerci de vérifier l'adresse e-mail saisie.");
                        return;
                    }

                    $scope.suivant({userEmail : $scope.temp.email});
                };

                $scope.i = 0;
                $scope.clicMAJPassword = function(){

                    $scope.i++;
                    console.log($scope.i, $scope.showErrorShortPassword);
                    if($scope.user.plainPassword.length<8) {
                       // if($scope.i<2)
                        $scope.showErrorShortPassword = true;
                        console.log($scope.showErrorShortPassword);
                        return;
                    }else if($scope.user.plainPassword.length>50) {
                        $scope.showErrorLongPassword = true;
                        return;
                    }
                    if($scope.user.emailPersonnel != null && angular.equals($scope.user.emailPersonnel, $scope.temp.email))
                    {
                        $scope.showErrorSameEmail = true;
                        return;
                    }


                    console.log($scope.user);
                    //
                    $scope.showAlmostDone = true;
                    $scope.showMAJPassword = false;
                }

                $scope.closeError = function () {
                    $scope.showErrorShortPassword = false;
                    $scope.showErrorLongPassword = false;
                }

                $scope.closeSameEmail = function () {
                    $scope.showErrorSameEmail = false;
                }

                $scope.imgData= {
                    croppedDataUrl: null,
                    picFileName: null
                };
                //Ce scope venant du controller principal renvoit toujours un objet json
                $scope.clicUpload = function(croppedDataUrl, picFileName){
                    console.log("croppedDataUrl", croppedDataUrl);
                    console.log("picFileName", picFileName);
                    $scope.imgData.croppedDataUrl = croppedDataUrl;
                    $scope.imgData.picFileName = picFileName;
                    $scope.upload({imgData : $scope.imgData});

                }

                $scope.clicAjoutPhoto = function () {
                    $scope.showAlmostDone = false;
                    $scope.showImageUpload = true;
                }

                $scope.closeThis = function () {
                    $scope.showAlmostDone = true;
                    $scope.showImageUpload = false;
                }
                
                $scope.closeAjoutBox = function () {
                    $scope.showAlmostDone = true;
                    $scope.showImageUpload = false;
                    $scope.showImageSubmit = false;
                }

                $scope.clicImportPhoto = function () {
                    //console.log("clicImportPhoto");
                    $scope.showImageSubmit = true;
                    $scope.showImageUpload = false;
                }
                $scope.userData = {
                    login:null,
                    password:null,
                    gRecaptchaResponse:null
                };

                if($scope.chargementEnCours && $scope.cbExpiration != undefined) $scope.cbExpiration();


                $scope.clicConnexion = function () {

                    $scope.userData.login = $scope.temp.email;
                    $scope.userData.password = $scope.user.plainPassword;

                    $scope.showCredentialsError = false;


                    if($scope.widgetId>=1 && $scope.response === null){ //if string is empty
                        alert("Please resolve the captcha and submit!");
                        return;
                    }else if($scope.widgetId>=1 && $scope.response !== null)
                    {
                        console.log("else if($scope.widgetId>1 && $scope.response !== null)");
                        $scope.userData.gRecaptchaResponse = $scope.response ;
                    }
                    console.log("userData: ");
                    console.log($scope.userData);
                    $scope.connexion({userData: $scope.userData});

                }

                $scope.checkingCredentials = function () {

                    if($scope.chargementEnCours){
                        $scope.cbExpiration();
                        return true;
                    }
                    return false;

                }

                $scope.response = null;
                $scope.widgetId = null;

                $scope.model = {
                    key: '6LfLyBAUAAAAANE97OVWKJL51BEnRa7Pj3atosRR'
                };

                $scope.setWidgetId = function (widgetId) {
                    console.info('Created widget ID: %s', widgetId);
                    $scope.widgetId = widgetId;
                };

                $scope.setResponse = function (response) {
                    console.info('Response available');
                    $scope.response = response;
                };

                $scope.cbExpiration = function() {
                    console.log('Captcha expired. Resetting response object');
                    vcRecaptchaService.reload($scope.widgetId);
                    $scope.response = null;
                };

                $scope.clicSignUp = function () {
                   // console.log($scope.response);
                    if($scope.response === null){ //if string is empty
                        alert("Please resolve the captcha and submit!");
                        return;
                    }
                    $scope.user.gRecaptchaResponse = $scope.response ;
                    $scope.user.croppedDataUrl = $scope.imgData.croppedDataUrl ;
                    $scope.user.picFileName = $scope.imgData.picFileName;
                    console.log($scope.user);
                    $scope.signUp({user : $scope.user})

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
            conteneurQuestion: "="
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
             answer: "=",
           checkRef: '&',
       checkInutile: '&',
      posterComment: '&'
        },

        controller: function ($scope) {
            var data = {};


            $scope.clickCheckComment = function (ref, refID) {
                $scope.checkRef({ref: ref , refID: refID} );
            }
            $scope.clickCheckInutile= function (ref, refID) {
                $scope.checkInutile({ref: ref , refID: refID} );
            }

            $scope.clickPosterCommentaire = function (libelle, reponseID) {

                if(libelle==undefined || libelle.length<=15)
                {
                    alert("Un commentaire doit contenir au minimum 15 caractères !");
                    return;
                }
                $scope.posterComment({newComment:libelle , answerID: reponseID});
            }

        }
    }
})

    .directive("administration", function () {
        return {
            restrict: "E",
            templateUrl: '/administration',
            replace: true
        }
    })

    .directive("review", function () {
        return {
            restrict: "E",
            templateUrl: '/review',
            replace: true
        }
    })




