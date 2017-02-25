app.controller("LectureContenuCtrl", function ($scope, $filter,  $http, $sce,contenuService, ngDialog, $rootScope, $location, $window) {

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
        console.log($scope.afficherNewQuestion);
        //$scope.getConteneurByID($scope.idConteneurSelectionne);
    }

    $scope.displayQuestionDetail = function(id)
    {
        //if($scope.conteneurCourant==null) return;
        console.log("displayQuestionDetail", $scope.conteneurCourant);
        $scope.questionDetailFullscreen = $scope.questionFullscreen;
        $scope.idQuestionSelectionnee = id;
        $scope.getQuestionByID($scope.idQuestionSelectionnee);

        if(sessionStorage.idQuestion != undefined) delete sessionStorage.idQuestion;

    }

    // Création d'une question

    $scope.afficherNewQuestion = false;
    $scope.showQuestionError = false;
    $scope.tinyMceReponse = false;
    $scope.conteneurCourant = null;
    $scope.idQuestion = 0;
    var myImages = [];

    $scope.optionTinyMCE = {
        language: "fr_FR",
        selector: "textarea",
        height: 200,

        resize: "height",
        menubar: false,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks codesample fullscreen",
            "insertdatetime media table contextmenu paste"
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
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        /*myImages.push(e.target.result);

                        console.log(myImages);*/
                        console.log(file);
                        var fileExtension = file.name.substr(file.name.lastIndexOf('.')+1);
                        console.log(fileExtension);
                        if(!angular.equals(fileExtension, "png") &&
                                            !angular.equals(fileExtension, "jpeg") &&
                                                !angular.equals(fileExtension, "jpg") &&
                                                    !angular.equals(fileExtension, "gif"))
                        {
                            alert("Veuillez sélectionner une image");
                            return;
                        }

                        if(file.size>1000000)
                        {
                            alert("L'image doit être inférieur à 1Mb");
                            return;
                        }
                        var imageData = {
                            userID: $scope.authToken.user.id,
                              name: file.name,
                            imgB64: e.target.result

                        }
                        //console.log(imageData);
                        contenuService.postImage(imageData).$promise.then(function (data) {
                            console.log(data);
                            callback(data.imageRoot, {
                                alt: ''
                            });
                        })

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

    $scope.majQuestionVu = function(idQuestion)
    {

        contenuService.patchQuestion({}, idQuestion);

    }

    $scope.publierQuestion = function(newQuestion)
    {
        console.log(newQuestion);
        contenuService.postQuestion(newQuestion, sessionStorage.idContenuCourant, $scope.authToken.user.id, 1).then(function(data){

            $scope.afficherNewQuestion = false;
            $location.path("/");
            $window.location.reload();
        });

    }

    $scope.showTinyMceReponse = function (idQuestion) {
        console.log(idQuestion);
        $scope.idQuestion = idQuestion;
        $scope.tinyMceReponse = true;

    }

    $scope.newReponse = {};
    $scope.publierReponse = function(newReponse, questionID)
    {
        if(newReponse.libelle==undefined || newReponse.libelle.length<=30){
            alert("Une réponse doit contenir au minimum 30 caractères !");
            return;
        }

        contenuService.postReponse(newReponse, questionID, $scope.authToken.user.id).then(function(data){

            var reponseQuestion = angular.toJson(data);
            $scope.questionSelectionnee.reponses.push(angular.fromJson(reponseQuestion));
            console.log($scope.questionSelectionnee.reponses);
            $scope.newReponse.libelle = null;
            $scope.idQuestion = 0;
            $scope.tinyMceReponse = false;

        });
    }

    $scope.posterComment = function(newComment, answerID)
    {
        var commentaire = {"libelle":newComment};

        contenuService.postCommentaire(commentaire, answerID, $scope.authToken.user.id).then(function(data){
            var commentResponse = angular.toJson(data);
            //console.log(angular.fromJson(commentResponse));
            //$scope.questionSelectionnee.reponses.push(angular.fromJson(commentResponse));

            angular.forEach($scope.questionSelectionnee.reponses, function(reponse, key) {
                    if(reponse.id == answerID) reponse.commentaires.push(angular.fromJson(commentResponse));
                    console.log(reponse);
                });
        });
    }

    $scope.getConteneurByID = function(id)
    {

        $scope.idConteneurSelectionne = id;

        contenuService.getConteneur(id).$promise.then(function(data){
            $scope.conteneurCourant = data;

            $scope.contenuRoot = $scope.conteneurCourant.contenu.contenuRoot;
            $scope.contenuURL = $sce.trustAsResourceUrl("https://docs.google.com/viewer?embedded=true&url=" + $scope.contenuRoot);
            $scope.sousRubriqueLibelle = ($scope.conteneurCourant.contenu.sousRubrique!=null)?$scope.conteneurCourant.contenu.sousRubrique.libelle:"contenu";
            $scope.conteneurQuestion = $scope.conteneurCourant.contenu.questions;

            if(sessionStorage.idQuestion != undefined){
                var idQuestion = parseInt(sessionStorage.idQuestion);
                $scope.displayQuestionDetail(idQuestion);
            }
            sessionStorage.idContenuCourant = $scope.conteneurCourant.contenu.id;

            $scope.userContenuData = {};

            $scope.userContenuCourant = $filter('filter')($scope.conteneurCourant.contenu.userContenus, function (data) {

                return data.user.id === $scope.authToken.user.id;
            })[0];
            // var nbreVue = userContenuCourant.nbreVue;

            ($scope.userContenuCourant == undefined)?$scope.userContenuData.nbreVue=1:$scope.userContenuData.nbreVue=$scope.userContenuCourant.nbreVue+1;

            contenuService.getUserVote($scope.conteneurCourant.contenu.id, "Contenu", $scope.authToken.user.id).$promise.then(function(data){
                Prism.highlightAll();
                $scope.userVote = data;

            });
            sessionStorage.nbreVue = $scope.userContenuData.nbreVue;
            //console.log("userContenuData", $scope.userContenuData);
            //contenuService.patchUserContenu($scope.userContenuData, $scope.authToken.user.id, $scope.conteneurCourant.contenu.id);

        });

    }

    $scope.ngbind=function (value) {
        console.log(value);
    }

    $scope.getQuestionByID = function(idQuestion)
    {
        // IMPORTANT ngInit
        // Mettre ce genre de condition sur tous les scopes que vont utiliser le controller, sinon le controller
        // qui s'execute en premier va initialiser à null et ces scopes perdront leur valeurs qui doivent provenir de ngInit
        console.log("getQuestionByID", $scope.conteneurCourant);
        Prism.highlightAll();
        if($scope.conteneurCourant==null) return;

        //$scope.conteneurCourant.$promise.then(function(){
        $scope.questionSelectionnee = $filter('filter')($scope.conteneurCourant.contenu.questions, function (d) {
            Prism.highlightAll();
            return d.id === idQuestion;
        })[0];
        //});


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
        var newScope = $scope.$new();
        newScope.data = $scope.userContenuCourant;
        if($scope.userContenuCourant.review != undefined)
            newScope.data.oldReview = $scope.userContenuCourant.review;
        ngDialog.open({
            template: '/review',
            className: 'ngdialog-theme-default',
            scope: newScope,
            controller: 'DiaglogCtrl' });
        //console.log($scope.userContenuCourant.review);
    };



    if(localStorage.userData != undefined)
    {
        $scope.authToken = angular.fromJson(localStorage.userData);
        $http.defaults.headers.common["X-Auth-Token"] =  $scope.authToken.value;
    }

    //Default values


    $scope.content = {}

    $scope.rate = function () {
        $scope.content.ref = "Contenu";
        $scope.content.refID = $scope.conteneurCourant.contenu.id;
        $scope.content.userID = $scope.authToken.user.id;
        $scope.content.valeur = $scope.userVote.valeur;
        contenuService.patchRating($scope.content);
        // console.log($scope.content);
    }

    $scope.checkRef = function (ref, refID)
    {

        //console.log(ref, refID);

        if(ref.ref != undefined && ref.ref == "Commentaire")
        {
            ref = 'Commentaire';
            refID = refID.refID;
        }

        //console.log(ref, refID);

        var voteData = {
            "ref": ref,
            "refID": refID,
            "userID": $scope.authToken.user.id,
            "valeur": 1
        };

        contenuService.postCheck(voteData).$promise.then(function(data){

            if(angular.equals(ref, "Question")) $scope.questionSelectionnee.nombreLike = data.nombreLike;

            if(angular.equals(ref, "Reponse")){

                angular.forEach($scope.questionSelectionnee.reponses, function(reponse, key) {
                    if(reponse.id == refID) reponse.nombreLike = data.nombreLike;
                });

            }

            if(angular.equals(ref, "Commentaire")){

                angular.forEach($scope.questionSelectionnee.reponses, function(reponse, key) {
                    angular.forEach(reponse.commentaires, function(comment, key) {
                        if(comment.id == refID) comment.nombreLike = data.nombreLike;
                    });
                });

            }
        });

    }


    $scope.checkInutile = function (ref, refID)
    {

        //console.log(ref, refID);

        if(ref.ref != undefined && ref.ref == "Commentaire")
        {
            ref = 'Commentaire';
            refID = refID.refID;
        }

        //console.log(ref, refID);

        var inutileData = {
            "ref": ref,
            "refID": refID,
            "userID": $scope.authToken.user.id
        };

        contenuService.postInutile(inutileData).$promise.then(function(data){

            if(angular.equals(ref, "Question")) $scope.questionSelectionnee.nbreInutile = data.nbreInutile;

            if(angular.equals(ref, "Reponse")){

                angular.forEach($scope.questionSelectionnee.reponses, function(reponse, key) {
                    if(reponse.id == refID) reponse.nbreInutile = data.nbreInutile;
                });

            }

            if(angular.equals(ref, "Commentaire")){

                angular.forEach($scope.questionSelectionnee.reponses, function(reponse, key) {
                    angular.forEach(reponse.commentaires, function(comment, key) {
                        if(comment.id == refID) comment.nbreInutile = data.nbreInutile;
                    });
                });

            }
        });

    }

    $scope.init = function ($id) {
        $scope.getConteneurByID($id);
    }


/*    var timeSpentOnPage = TimeMe.getTimeOnCurrentPageInSeconds();
    console.log(timeSpentOnPage);

    contenuService.postCheck({timeSpentOnPage:timeSpentOnPage});*/





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
                    sessionStorage.idQuestion = idQuestion;
                    if($scope.getQuestionByID(idQuestion)) {
                        $scope.majQuestionVu(idQuestion);
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

app.controller("DiaglogCtrl", function ($uibModal,$uibModalStack, $scope, contenuService, ngDialog) {

    $scope.closeThisDialog = function (review) {

        if(review==undefined || !(review.length>=15 && review.length<=500)) return;

        var userContenuData = {};
        userContenuData.review = review;

        contenuService.patchUserContenu(userContenuData, $scope.authToken.user.id, sessionStorage.idContenuCourant);

        ngDialog.close();
    }
})

