$(document).ready(function () {
    $("#notificationLink").click(function () {
        $("#notificationContainer").fadeToggle(300);
        //$("#notification_count").fadeOut("slow")
        $("#notification_count").fadeToggle(300);

        $('#notificationLink > i.fa-bell').addClass('fa-bell-o');
        $('#notificationLink > i.fa-bell').removeClass('fa-bell');
        return false;
    });

    //Document Click hiding the popup
    $(document).click(function () {
        $("#notificationContainer").hide();
        $("#notification_count").fadeIn("slow");
    });

    //Popup on click
    $("#notificationContainer").click(function () {
        return false;
    });

});

app.controller("NotifCtrl", function ($filter, $http,$rootScope , $window, $scope, $sce, $location, $anchorScroll,
                                      $interval, $timeout, Upload, $uibModal,$uibModalStack, contenuService) {

    var authToken = angular.fromJson(localStorage.userData);
    $scope.user = authToken.user;
    $scope.notification = {};
    var firstNotif = false;
    contenuService.getNotifierByUser($scope.user.id).$promise.then(function (data) {
        //Cette notification correspond à notifier de l'api
        $scope.notifications = data[0];
        $scope.notificationCount = data[1]["nbreDeNotifs"];

    }, function (error) {
        console.log(error);
    });



    var updateNotifications = function() {
        if(!$rootScope.chargementEnCours)
        {
            $rootScope.blockLoading=true;
            $rootScope.chargementRubrique = false;
            contenuService.getNotifierByUser($scope.user.id).$promise.then(function (data) {
                $scope.notifications = data[0];
                $scope.notificationCount = data[1]["nbreDeNotifs"];
                $rootScope.chargementRubrique = false;
                console.log("$scope.notifications", $scope.notifications);
            }, function (error) {
                console.log(error);
            });
        }
    };
  //  $interval(updateNotifications,30000);



    $scope.notficationHasBeenSeen = function () {
        $rootScope.blockLoading = true;
        $scope.notificationCount = 0;
        console.log("hasSeen", $scope.notifications[0]);
        contenuService.patchNotificationsToVu({}, $scope.user.id, $scope.notifications[0].notificationID).$promise.then(function (data) {

        }, function (error) {
            console.log(error);
        })
    }
    $scope.notificationHasBeenRead = function (notififierID) {
        $rootScope.blockLoading = true;
        contenuService.patchNotificationToLu({}, notififierID).$promise.then(function (data) {
        }, function (error) {
            console.log(error);
        })
    }


})

