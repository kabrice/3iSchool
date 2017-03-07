app.controller("DashboardCtrl", function ($filter, $http,$rootScope , $window, $scope, $sce, $location, $anchorScroll,
                                             $interval, $timeout, Upload, $uibModal,$uibModalStack, contenuService) {

    $scope.showPublierContenu = true;
    $scope.fileModel = null;
    $scope.thumbnail = {};
    $scope.tmp = {
        note:0,
        date: new Date()
    }

    $rootScope.chargementNouveauContenu = false;
    $scope.clickShowRubrique= function (publierContenu, questionManager, contenusSignales, mesCours) {

        $scope.showPublierContenu = publierContenu;

        $scope.showQuestionManager = questionManager;

        $scope.showContenusSignales = contenusSignales;

        $scope.showMesCours = mesCours;

    }

    
      function initFields() {


          $scope.selectedDashBoardValue = {
              anneeid: "2"
          };


          $scope.selectedRubrique = {
              selected: {
                  id:1,
                  libelle: "Analyse Numérique"
              }
          };


          $scope.selectedNiveau = {
              selected: null
          };


          $scope.selectedGroupe = {
              selected: null
          };

          $scope.selectedSousRubrique = {
              selected: {
                  id:1,
                  libelle: "Cours"
              }
          };

          if(previousData!=undefined) {
              $scope.selectedDashBoardValue.anneeid = previousData.anneeid;
              $scope.selectedDashBoardValue.titre = previousData.titre;
              $scope.selectedDashBoardValue.description = previousData.description;
              $scope.selectedRubrique.selected = previousData.rubrique;
              $scope.selectedSousRubrique.selected = previousData.sousRubrique;
          }

              contenuService.getAnnee().$promise.then(function (data) {
                  $scope.annees = data;
              });

              contenuService.getGroupe().$promise.then(function (data) {
                  $scope.groupes = data;

                  if(previousData!=undefined) {
                      $scope.selectedGroupe.selected = previousData.listeGroupes;
                  }else{
                      $scope.selectedGroupe.selected = [$scope.groupes[0]];
                  }

              });

              contenuService.getNiveau().$promise.then(function (data) {
                  $scope.niveaux = data;
                  if(previousData!=undefined) {
                      $scope.selectedNiveau.selected = previousData.listeNiveaux;
                  }else{
                      $scope.selectedNiveau.selected = [$scope.niveaux[1]];
                  }

              });

              contenuService.getRubriques().$promise.then(function (data) {
                  $scope.rubriques = data;
              });

              contenuService.getSousRubriques().$promise.then(function (data) {
                  $scope.sousRubriques = data;
              });

    }


    $scope.logOut = function () {

        contenuService.deleteAuthToken($scope.authToken.id);
        delete localStorage.userData;
        delete localStorage.previousData;
        delete localStorage.promotion;
        $window.location.href = '/';
    }

    $scope.submit = function() {
        if ($scope.form.file.$valid && $scope.file) {
            $scope.upload($scope.file);
        }
    };

    $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;

        $scope.errFile = errFiles && errFiles[0];
        if (file) {
            file.upload = Upload.upload({
                url: 'api/xxx',
                data: {file: file}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 *
                    evt.loaded / evt.total));
            });
        }
    }



    function previewFile() {
        var preview = document.querySelector('img');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
    var contenu = {};
    $scope.creerContenu = function (selectedDashBoardValue, selectedGroupe, selectedNiveau, selectedRubrique, selectedSousRubrique) {
        console.log(selectedDashBoardValue, selectedGroupe, selectedNiveau, selectedRubrique, selectedSousRubrique);

        if(!selectedDashBoardValue.titre || !selectedDashBoardValue.description) {
            alert("Impossible de publier!\nVérifiez que tous les champs sont remplis et valides.");
            return;
        }else if(!$scope.chunckFinished){
            alert("Impossible de publier!\nAssurez vous que l'upload du fichier est bien à 100%.");
            return;
        }
        if(angular.equals($scope.fileExtension, "pdf") || angular.equals($scope.fileExtension, "mp4"))
        {
             var imageName = "cover_"+$scope.fileName.substring(0, $scope.fileName.lastIndexOf('.')+1)+"png";
             var canvas = document.getElementById('canvas');
            contenu.imgB64 = canvas.toDataURL();
            contenu.imageRoot = "cover/"+imageName;
        }else{
            contenu.imgB64 = null;
            contenu.imageRoot = $scope.thumbnail.source;
        }

        contenu.titre = selectedDashBoardValue.titre;
        contenu.description = selectedDashBoardValue.description;
        contenu.contenuRoot = $scope.contenuRoot;
        console.log()
        contenu.listeGroupes = $scope.selectedGroupe.selected;
        contenu.listeNiveaux = $scope.selectedNiveau.selected;
        $window.location.reload();
        contenuService.postConteneur(contenu, selectedDashBoardValue.anneeid, selectedRubrique.selected.id, selectedSousRubrique.selected.id, $scope.authToken.user.id).$promise.then(function (data) {
            sessionStorage.success = true;
            var previousData = {
                titre: contenu.titre,
                description: contenu.description,
                anneeid: selectedDashBoardValue.anneeid,
                listeGroupes: $scope.selectedGroupe.selected,
                listeNiveaux: $scope.selectedNiveau.selected,
                rubrique: selectedRubrique.selected,
                sousRubrique: selectedSousRubrique.selected

            }

             localStorage.previousData = angular.toJson(previousData);
              console.log(data);
        }, function (error) {
            sessionStorage.success = false;
            console.warn(error.data);
        })

    }




    $scope.publierContenu = function (contenuData, selectedRubrique, selectedNiveau ) {

        console.log(contenuData, selectedRubrique, selectedNiveau );
    }

    /*** *** *** *** ***  WATCHER  *** *** *** *** ***/

    $scope.currentPage = 1; // keeps track of the current page
    $scope.pageSize = 10; // holds the number of items per page
    function isInt(value) {
        return !isNaN(value) &&
            parseInt(Number(value)) == value &&
            !isNaN(parseInt(value, 10));
    }
    $scope.$watch(function(){
        return $location.path();
    }, function (newPath) {

        var tabPath = newPath.split("/");

        function clickShowSousRubrique(numSousRubrique, enseignantRecherche) {
            $scope.labels = [];
            $scope.data = [];
           // $scope.enseignantCourant = enseignantRecherche;
            contenuService.getUser(enseignantRecherche + "@3il.fr").$promise.then(function (data) {
                console.log(data[0].id);
                $scope.showQuestionManager = false;
                getStatContenuData(data[0].id, numSousRubrique);
            }, function (error) {
                getStatContenuData($scope.authToken.user.id, numSousRubrique);
                console.log(error.data);
            })
        }
        function parseTimestamp(timestampStr) {
            //if(timestampStr==0) return new Date(new Date(timestampStr).getTime());
            return new Date(new Date(timestampStr).getTime() + (new Date().getTimezoneOffset() * 60 * 1000*24));
        }
        function convertDate(inputFormat) {
            function pad(s) { return (s < 10) ? '0' + s : s; }
            var d = new Date(inputFormat);
            return [pad(d.getDate()+1), pad(d.getMonth()+1), d.getFullYear()].join('/');
        }
        function getAllDays(start, end) {
            //console.log("s==e", start,end);
            if(start==end)
            {
                console.log("s==e", $scope.labels,$scope.data );
                a = $scope.labels;
                $scope.data = [$scope.data];
                return
            }
            var s = parseTimestamp(start);
            var e = parseTimestamp(end);
            console.log("s, e", s,e);
            var a = [], d = [];
            var size=Math.round((e-s)/(1000*60*60*24));
            while(size--) d[size] = 0;
            var i, p=0;
            while(s <= e) {
                a.push(convertDate(s));
                i=0;
                angular.forEach($scope.labels, function(reponse, key) {

                    if(s.getTime() == parseTimestamp(reponse).getTime())
                    {
                        d[p] = $scope.data[i];
                    }
                    i++;
                });
                s = new Date(s.setDate(
                    s.getDate() + 1
                ))
                p++;
            }



            if(a.length == 0) console.log(start, end);
            $scope.labels = a;
            $scope.data = [d];
           // console.log( a, d);
            return a;
        }

        function getVisiteData(contenuID) {
            contenuService.getAllVisiteContenu(contenuID).$promise.then(function (data) {
                angular.forEach(data, function(reponse, key) {
                    $scope.labels.push(reponse.dateVite);
                    $scope.data.push(parseInt(Math.round(reponse.dureeTotale)));

                });

                getAllDays($scope.labels[0], $scope.labels[$scope.labels.length-1]);
                //console.log("a", a);
                //$scope.data= [$scope.data];
                // console.log($scope.labels, $scope.data);
            }, function (error) {
                console.log(error.data);
            })
            $scope.dureeTotalVisiteur = [];
            $scope.userNote=[];
            contenuService.getUserContenuByContenu(contenuID).$promise.then(function (data) {
                $scope.userContenuByContenu = data;

                angular.forEach($scope.userContenuByContenu, function(reponse, key) {
                    var dureeTotalTmp= 0;
                    contenuService.getVisiteContenu(contenuID, reponse.user.id).$promise.then(function (data) {
                        angular.forEach(data, function(reponse, key) {
                            dureeTotalTmp+=reponse.duree;
                            if(reponse.user!=undefined) $scope.dureeTotalVisiteur[reponse.user.id]= Math.round(dureeTotalTmp);
                        });
                        console.log("dureeTotalTmp", dureeTotalTmp);

                    })
                    if(reponse.user!=undefined)
                    contenuService.getUserNote(contenuID, reponse.user.id).$promise.then(function (data) {
                            if(data[0] != undefined) {
                                $scope.userNote[reponse.user.id] = data[0].valeur;
                                console.log("reponse.user.id", reponse.user.id);
                                console.log("data", data[0].valeur);
                            }

                    })
                    if(reponse.user==undefined) $scope.userNote[reponse.user.id]=0;
                    console.log(reponse.user.id, dureeTotalTmp)

                    //console.log(reponse);
                });

                console.log("userContenuByContenu", data);
            }, function (error) {
                console.log(error);
            })

        }

        function getStatContenuData(userID, numSousRubrique) {
            $scope.userTemp=userID;
            console.log("$scope.userTemp", $scope.userTemp);
            contenuService.getRubriqueDashboard(userID, numSousRubrique).$promise.then(function (data) {
                $scope.sousRubriqueData = data;
                console.log("$scope.sousRubriqueData = data", $scope.sousRubriqueData = data);
                console.log("$scope.indexContenu", $scope.indexContenu);
                if($scope.indexContenu==undefined && numSousRubrique==5)
                {
                    $scope.contenuStat = $scope.sousRubriqueData[0];
                    $scope.numSousRubrique=numSousRubrique;
                    getVisiteData($scope.contenuStat.id);
                }else {
                    $scope.numSousRubrique=numSousRubrique;
                    //console.log("$scope.indexContenu", $scope.indexContenu);
                    showContenuStat($scope.indexContenu);
                }

                //console.log("$scope.contenuStat.id", $scope.contenuStat.id);

            })
        }

        function showContenuStat(index) {

            console.log("index",index);

                $scope.contenuStat = $scope.sousRubriqueData[index];
                console.log("test", $scope.sousRubriqueData[index]);
                $scope.labels = [];
                $scope.data = [];
                if(index!=undefined)
                getVisiteData($scope.contenuStat.id);
                $location.hash("contenuStat");
                $anchorScroll();


        }
        $scope.getUserID = function (userID) {

            sessionStorage.userID = userID;

        }

        if(tabPath.length>1)
        {
            var categorie = tabPath[1];

            switch(categorie) {
                case 'nouveauContenu':
                    $scope.clickShowRubrique(true, false, false, false);
                    if($scope.annees==undefined)
                    initFields();
                    break;

                case 'gestionQuestions':
                    var enseignantRecherche = tabPath[2];

                    $scope.currentPage = 1; // keeps track of the current page
                    $scope.pageSize = 10; // holds the number of items per page

                        contenuService.getUser(enseignantRecherche + "@3il.fr").$promise.then(function (data) {
                            console.log(data[0].id);
                            $scope.showQuestionManager = false;
                            contenuService.getRubriqueDashboard(data[0].id, 1).$promise.then(function (data) {
                                $scope.questionsEtudiants = data;
                                $scope.showQuestionManager = true;
                                $scope.clickShowRubrique(false, true, false, false);

                                console.log($scope.questionsEtudiants);
                            })
                        }, function (error) {
                            contenuService.getRubriqueDashboard($scope.authToken.user.id, 1).$promise.then(function (data) {
                                $scope.questionsEtudiants = data;
                                $scope.showQuestionManager = true;
                                $scope.clickShowRubrique(false, true, false, false);
                                console.log($scope.questionsEtudiants);
                            })
                            console.log(error.data);
                        })

                    //if($scope.gestionQuestions != undefined)
                    //console.log($scope.gestionQuestions );

                    break;

                case "contenusSignales":
                    $scope.clickShowRubrique(false, false, true, false);


                    var sousRubrique = tabPath[2];
                     enseignantRecherche = tabPath[3];

                        switch(sousRubrique) {
                            case 'questions':
                                clickShowSousRubrique(2, enseignantRecherche);
                                break;

                            case 'reponses':
                                clickShowSousRubrique(3, enseignantRecherche);
                                break;

                            case "commentaires":
                                clickShowSousRubrique(4, enseignantRecherche);
                                break;

                            default:
                                clickShowSousRubrique(2);
                        }

                    break;

                case "mesCours":

                    enseignantRecherche = tabPath[2];
                    console.log(enseignantRecherche);
                    $scope.clickShowRubrique(false, false, false, true);
                    clickShowSousRubrique(5, enseignantRecherche);
                    $scope.indexContenu = tabPath[3];
                    //if(isInt(indexContenu)) showContenuStat(indexContenu);
                    break;

                default:

            }

        }else{
            if($scope.annees==undefined)
            initFields();
        }

    });


    $scope.invalidFiles = [];

    // make invalidFiles array for not multiple to be able to be used in ng-repeat in the ui
    $scope.$watch('invalidFiles', function (invalidFiles) {
        if (invalidFiles != null && !angular.isArray(invalidFiles)) {
            $timeout(function () {$scope.invalidFiles = [invalidFiles];});
        }
    });

    $scope.$watch('files', function (files) {
        $scope.formUpload = false;
        if (files != null) {
            $scope.showBox = false;
            // make files array for not multiple to be able to be used in ng-repeat in the ui
            if (!angular.isArray(files)) {
                $timeout(function () {
                    $scope.files = files = [files];
                });
                return;
            }
            for (var i = 0; i < files.length; i++) {
                $scope.errorMsg = null;
                (function (f) {
                    $scope.upload(f, true);
                })(files[i]);
            }
        }else{
            $scope.showBox = true;
        }
    });

    $scope.uploadPic = function (file) {
        $scope.formUpload = true;
        if (file != null) {
            $scope.upload(file);
        }
    };

    $scope.showBox = true;
    $scope.upload = function (file, resumable) {
        //$scope.showBox = false;
        //console.log("file", f.progress)
        $scope.errorMsg = null;
        if ($scope.howToSend === 1) {
            uploadUsingUpload(file, resumable);
        } else if ($scope.howToSend == 2) {
            uploadUsing$http(file);
        } else {
            uploadS3(file);
        }
    };



    $scope.isResumeSupported = Upload.isResumeSupported();

    $scope.restart = function (file) {
        if (Upload.isResumeSupported()) {
            $http.get('/api/contenu/contenuRoot?restart=true&name=' + encodeURIComponent(file.name)).then(function () {
                $scope.upload(file, true);
            });
        } else {
            $scope.upload(file);
        }
    };


    $scope.validResult = true;
    $scope.chunckFinished = false;
    $scope.fileData = null;
    $scope.chunkSize = '500KB';
    function uploadUsingUpload(file, resumable) {
        $scope.fileName = file.name;

        if($scope.contenuRoot!=undefined) $scope.contenuRoot=undefined;

        if(isFileExist(file.name))
        {
            alert("Ce nom de fichier existe déjà !\nRecliquez dans le rectangle pour en sélectionner un autre.");
            return
        }
        if(!($scope.validResult = isFileValid(file))) return;
        $rootScope.blockLoading = true;

        file.upload = Upload.upload({
            url: '/api/contenu/contenuRoot' + $scope.getReqParams(),
            method: 'POST',
            resumeChunkSize: resumable ? $scope.chunkSize : null,
            //file: file,
            data: {
                userID:1,
                name: $scope.username,
                imgB64:"fefe",
                file: file,
                uid: Date.now(),
                targetPath: 'media/'
            }
        });

        var result = file.upload.then(function (response) {

            $timeout(function () {
                file.result = response.data;
                $scope.fileData = response.data;
                $scope.chunckFinished = true;
                setFileThumbnail();
                $scope.contenuRoot = response.data.contenuRoot;
                console.log($scope.contenuRoot);



            });
        }, function (response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
        console.log("result", result);
        file.upload.xhr(function (xhr) {
            // xhr.upload.addEventListener('abort', function(){console.log('abort complete')}, false);
        });
    }

    $scope.success_action_redirect = $scope.success_action_redirect || window.location.protocol + '//' + window.location.host;
    $scope.jsonPolicy = $scope.jsonPolicy || '{\n  "expiration": "2020-01-01T00:00:00Z",\n  "conditions": [\n    {"bucket": "angular-file-upload"},\n    ["starts-with", "$key", ""],\n    {"acl": "private"},\n    ["starts-with", "$Content-Type", ""],\n    ["starts-with", "$filename", ""],\n    ["content-length-range", 0, 524288000]\n  ]\n}';
    $scope.acl = $scope.acl || 'private';

    $scope.confirm = function () {
        return confirm('Are you sure? Your local changes will be lost.');
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode +
        '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    angular.element(window).bind('dragover', function (e) {
        e.preventDefault();
    });
    angular.element(window).bind('drop', function (e) {
        e.preventDefault();
    });

    //$scope.thumbnail.fileType = null;

    function isFileValid(file) {
         $scope.fileExtension = file.name.substr(file.name.lastIndexOf('.')+1);
        var result = true;
        console.log($scope.ileExtension);


        switch($scope.fileExtension) {
            case 'doc': case 'docx': case 'docm': case 'dot'||  'dotx': case 'dotm': case 'html': case 'plain': case 'txt': case 'rtf'  :

                $scope.thumbnail.fileType = 'document';

                break;

            case 'xls': case 'xlsx': case 'xlsm': case 'xlt': case 'xltx': case 'xltm': case 'ods': case 'csv': case 'tsv': case 'tab':

                $scope.thumbnail.fileType = 'spreadsheet';

                break;

            case 'ppt': case 'pptx': case 'pptm': case 'pps': case 'ppsx'|| 'ppsm': case 'pot': case 'potx': case 'potm' :

                $scope.thumbnail.fileType = 'presentation';

                break;

            case 'mp4':

                $scope.thumbnail.fileType = 'video';
                if(file.$ngfDuration>650)
                {
                    alert("Vidéo très longue. La vidéo ne doit pas dépasser 10min.");
                    result = false;
                }

                break;

            case 'zip':

                $scope.thumbnail.fileType = 'zip';

                break;

            case 'pdf':

                $scope.thumbnail.fileType = 'pdf';

                break;
            
            case 'jpg': case 'gif': case 'png' :

                $scope.thumbnail.fileType = 'image';

                break;

            default:
                $scope.thumbnail.fileType = 'unknown';

        }

        if(file.size>2000000000)
        {
            alert("Fichier trop lourd. Le fichier doit être inférieur à 2000Mb");
            result = false;
        }

        return result;

    }

    function isFileExist(filename)
    {
        var fileExist = false;
        if(filename) {
            var url = 'http://localhost:8000/media/' + filename;
            var request = new XMLHttpRequest();
            request.open('HEAD', url, false);
            request.send();
            if(request.status == 200) {
                 fileExist = true;
            }
        }
        return fileExist;
    }

    function setFileThumbnail() {

        switch($scope.thumbnail.fileType) {
            case 'document': case 'spreadsheet': case "presentation": case "zip": case "unknown":
                
                $scope.thumbnail.source = "cover/"+$scope.thumbnail.fileType+".png";
                console.log($scope.fileName);
            $scope.thumbnail.fileType = "image";
                break;
            default:

                $scope.thumbnail.source = "media/"+$scope.fileName;
        }
    }
    /*$scope.option = {
        name: 'Name (hover over for more details)',
        longDescription: 'This is my detailed description...  lots of text here'
    }*/
    $scope.showOptionDetails = function(userid, contenuid, titre, nom) {
        //console.log("Yeah");
        $scope.option = {
            userid: userid.userid,
            contenuid: contenuid.contenuid,
            titre: titre.titre,
            nom: nom.nom
        };
        console.info("option", $scope.option);
        //console.info("contenuid", contenuid);
        $scope.optionModal = $uibModal.open({
            templateUrl: '/chart',
            controller: 'ModalCtrl',
            resolve: {
                option: function() {
                    return $scope.option;
                }
            }
        });
    }





    $scope.howToSend=1;

    if(localStorage.userData != undefined)
    {
        $scope.authToken = angular.fromJson(localStorage.userData);
        $http.defaults.headers.common["X-Auth-Token"] =  $scope.authToken.value;
        if(!$scope.authToken.user.isPersonnel) $window.location.href = '/';
        var userEmail = $scope.authToken.user.email;

        $scope.username= userEmail.substr(0, userEmail.indexOf('@'));
        //$scope.enseignantCourant=$scope.username;
        $scope.logged = true;


        if(sessionStorage.success != undefined)
        {
            console.log(sessionStorage.success);
            $scope.sendSuccess = sessionStorage.success;
            delete sessionStorage.success;
        }

        if(localStorage.previousData != undefined)
        {
            console.log(angular.fromJson(localStorage.previousData));
            var previousData = angular.fromJson(localStorage.previousData);
        }

         initFields();

    }

})

app.controller("ModalCtrl", function ($uibModal,$uibModalStack, $scope, contenuService, option) {
    $scope.labels = [];
    $scope.data = [];
    $scope.option=option;
    contenuService.getVisiteContenu(option.contenuid, option.userid).$promise.then(function (data) {
        console.log(data);
        angular.forEach(data, function(reponse, key) {
            $scope.labels.push(formatDate(reponse.dateVisite));
            $scope.data.push(reponse.duree);
        });
        getAllDays($scope.labels[0], $scope.labels[$scope.labels.length-1]);
    }, function (error) {
        console.log(error);
    })
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + (d.getDate()-1),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
    function parseTimestamp(timestampStr) {
        //if(timestampStr==0) return new Date(new Date(timestampStr).getTime());
        return new Date(new Date(timestampStr).getTime() + (new Date().getTimezoneOffset() * 60 * 1000*24));
    }
    function convertDate(inputFormat) {
        function pad(s) { return (s < 10) ? '0' + s : s; }
        var d = new Date(inputFormat);
        return [pad(d.getDate()+1), pad(d.getMonth()+1), d.getFullYear()].join('/');
    }
    function getAllDays(start, end) {
        console.log("s==e", start,end);
        if(start==end)
        {
            console.log("s==e", $scope.labels,$scope.data );
            a = $scope.labels;
            $scope.data = [$scope.data];
            return
        }
        var s = parseTimestamp(start);
        var e = parseTimestamp(end);
        console.log("s, e", s,e);
        var a = [], d = [];
        var size=Math.round((e-s)/(1000*60*60*24));
        console.log("size",size);
        while(size--) d[size] = 0;
        var i, p=0;

        while(s <= e) {
            a.push(convertDate(s));
            i=0;
            angular.forEach($scope.labels, function(reponse, key) {

                if(s.getTime() == parseTimestamp(reponse).getTime())
                {
                    d[p] = parseInt(Math.round($scope.data[i]));
                }
                i++;
            });
            s = new Date(s.setDate(
                s.getDate() + 1
            ))
            p++;
        }



        if(a.length == 0) console.log(start, end);
        $scope.labels = a;
        $scope.data = [d];
        // console.log( a, d);
        return a;
    }


    $scope.series = ['durée en min'];
    $scope.onClick = function (points, evt) {
        console.log(points, evt);
    };
    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];
    $scope.options = {
        scales: {
            yAxes: [
                {
                    id: 'y-axis-1',
                    type: 'linear',
                    display: true,
                    position: 'left'

                }
            ],
            xAxes: [{
                responsive: true,
                ticks: {
                    autoSkip: true,
                    maxTicksLimit: 20
                }
            }]

        }

    };
    $scope.close = function() {
        $uibModalStack.dismissAll();
    }

})


