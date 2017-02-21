angular.module("DashboardDirectives", ['angular.filter', "MesFiltres", "vcRecaptcha"])
    .directive("questionManager", function () {

        return {
            restrict: "E",
            templateUrl: '/questionManager',
            replace: true,
            scope: {
                  contenu: "=",
                recherche: "="
            }


        }
    })

    .directive("contenusSignales", function () {

        return {
            restrict: "E",
            templateUrl: '/contenusSignales',
            replace: true,
            scope: {
                contenu: "=",
                recherche: "="
            }

        }
    })

    .directive("mesCours", function () {

        return {
            restrict: "E",
            templateUrl: '/mesCours',
            replace: true,
            scope: {
                contenu: "=",
                recherche: "=",
                showOptionDetails: "&"
            }

        }
    })