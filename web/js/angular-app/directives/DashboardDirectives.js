angular.module("DashboardDirectives", ['angular.filter', "MesFiltres", "vcRecaptcha"])
    .directive("questionManager", function () {

        return {
            restrict: "E",
            templateUrl: '/questionManager',
            replace: true,
            scope: {
              currentPage: "=",
                 pageSize: "=",
       questionsEtudiants: "="

            },
            controller: function ($scope) {
                $scope.search = {};
            }

        }
    })

    .directive("contenusSignales", function () {

        return {
            restrict: "E",
            templateUrl: '/contenusSignales',
            replace: true,
            scope: {
                currentPage: "=",
                pageSize: "=",
                sousRubriqueData: "=",
                numSousRubrique: "="
            },
            controller: function ($scope) {
                $scope.search = {};
            }

        }
    })

    /*.directive("sousRubriqueDashboard", function () {

        return {
            restrict: "A",
            templateUrl: '/sousRubriqueDashboard',
            replace: true,
            scope: {
                numSousRubrique: "=",
                dataSousRubrique: "="
            }

        }
    })*/

    .directive("mesCours", function () {

        return {
            restrict: "E",
            templateUrl: '/mesCours',
            replace: true,
            scope: {
                currentPage: "=",
                pageSize: "=",
                sousRubriqueData: "=",
                numSousRubrique: "=",
                contenu: "=",
                labels: "=",
                data: "=",
                showOptionDetails: "&",
                showContenuStat: "&"
            },
            controller: function ($scope, $location,$uibModal,$uibModalStack, $anchorScroll) {
                $scope.search = {};

                $scope.clicShowContenuStats = function (index) {
                    $location.hash("anchorContenuStat");
                    $anchorScroll();

                    $scope.showContenuStat(index);
                }

                $scope.hoverShowOptionDetails = function (option) {
                    console.log(option);
                    $scope.showOptionDetails({option: option});
                }

                $scope.series = ['Durée en min'];
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
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 20
                            }
                        }]

                    },
                    responsive: true,
                    maintainAspectRatio: false

                };
            }



        }
    })