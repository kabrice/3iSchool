app.controller("NotifCtrl", function ($scope, notificationService) {

    $scope.updateNotifications = function() {
        if(!$rootScope.chargementEnCours)
        {
            $rootScope.blockLoading=true;
            contenuService.getNotificationByUser($scope.user.id).$promise.then(function (data) {
                $scope.notifications = data[0];
                console.log("$scope.notifications", $scope.notifications);
            }, function (error) {
                console.log(error);
            });
        }
    };

    $interval($scope.updateNotifications,3000);



})

