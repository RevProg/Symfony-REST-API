var app = angular.module('restApp', ['ngRoute'])
    .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider
                .when('/', {templateUrl: '/js/app/views/list.html', controller: 'ListCtrl'})
                .when('/create', {templateUrl: '/js/app/views/create.html', controller: 'CreateCtrl'})
                .otherwise({redirectTo: '/'});
        },
    ]);
