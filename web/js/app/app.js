var app = angular.module('restApp', ['ngRoute','angularFileUpload'])
    .config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider
                .when('/', {templateUrl: '/js/app/views/list.html', controller: 'ListCtrl'})
                .when('/create', {templateUrl: '/js/app/views/create.html', controller: 'CreateCtrl'})
                .when('/edit/:id', {templateUrl: '/js/app/views/edit.html', controller: 'EditCtrl'})
                .when('/search', {templateUrl: '/js/app/views/search.html', controller: 'SearchCtrl'})
                .otherwise({redirectTo: '/'});
        },
    ]);
