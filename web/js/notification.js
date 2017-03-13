$(document).ready(function () {
    $("#notificationLink").click(function () {
        $("#notificationContainer").fadeToggle(300);
        $("#notification_count").fadeOut("slow");
        $('#notificationLink > i.fa-bell').addClass('fa-bell-o');
        $('#notificationLink > i.fa-bell').removeClass('fa-bell');
        return false;
    });

    //Document Click hiding the popup
    $(document).click(function () {
        $("#notificationContainer").hide();
    });

    //Popup on click
    $("#notificationContainer").click(function () {
        return false;
    });

    //$('#AddNew').on('click', function () {
    //    $('#notificationsBody ul').append('<li>New Message</li>');
    //});

});
app.controller("NotifCtrl", function ($filter, $http,$rootScope , $window, $scope, $sce, $location, $anchorScroll,
                                          $interval, $timeout, Upload, $uibModal,$uibModalStack, contenuService) {
    $scope.notifications = [{
        subject: 'Subject 1',
        body: 'body 1',
        param: 'someEncryptedString'
    }, {
        subject: 'Subject 2',
        body: 'body 2',
        param: 'someEncryptedString'
    }, {
        subject: 'Subject 3',
        body: 'body 3',
        param: 'someEncryptedString'
    }];
    $scope.addNotification = function () {
        $interval(function(){
            $scope.notifications.push({
                subject: 'New Subject',
                body: 'New Body',
                Param: 'Some Param'
            });
        },1000);
    };
})

