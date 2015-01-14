var app = angular.module('myApp',[
    'ui.router',
    'ngAnimate',
    'myApp.settings',
    'myApp.directives',
    'myApp.services',
    'myApp.controllers',
    'myApp.interceptors',
    'ngStorage'
]);

var viewsDir = "views/" ; // Views directory
var serverBaseUrl = "http://localhost/KYA" ;

app.config(['$locationProvider', function($locationProvider){
    $locationProvider.html5Mode(true);
}]);

app.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
}]);

app.config(function($sceProvider) {
    $sceProvider.enabled(false);
});

app.config(function($stateProvider,$urlRouterProvider){
    $urlRouterProvider.otherwise("/");
    //$scope.headerToggle = true ;
    $stateProvider
        .state('home', {
            url: '/',
            templateUrl: viewsDir + 'start.html',
            controller: 'StartController'
        })

        .state('select', {
            url: '/select-type',
            templateUrl: viewsDir + 'select.html',
            controller: 'SelectController',

            onEnter: function(){}
        })

        .state('states', {
            url: '/choose-state',
            templateUrl: viewsDir + 'states.html',
            controller: 'StateController'
        })

        .state('presAspirants', {
            url: '/presidential/aspirants',
            templateUrl: viewsDir + 'pres_aspirants.html',
            controller: 'PresAspController'
        })

        .state('presAspirantsProfile', {
            url: '/presidential/aspirants/:aspirantName',
            templateUrl: viewsDir + 'profile.html',
            controller: 'ProfileController'
        })

        .state('guberAspirants', {
            url: '/gubernatorial/aspirants/:state',
            templateUrl: viewsDir + 'gub_aspirants.html',
            controller: 'GubAspController'
        })

        .state('guberAspirantsProfile', {
            url: '/gubernatorial/aspirants/:state/:aspirantName',
            templateUrl: viewsDir + 'profile.html',
            controller: 'ProfileController'
        })

        .state('about', {
            url: '/about',
            templateUrl: viewsDir + 'about.html'
        })

        .state('404', {
            url: '/404',
            templateUrl: viewsDir + '404.html'
        });
}).run(function($rootScope){
    $rootScope.showSpinner = false ;
    $rootScope.$on('$locationChangeStart', function(event, next, current){
        $rootScope.showSpinner = true ;
    });

    $rootScope.$on('$locationChangeSuccess', function(){
        $rootScope.showSpinner = false ;
    });

    $rootScope.$on('loading:progress', function(){
        $rootScope.showSpinner = true ;
    });

    $rootScope.$on('loading:finish', function(){
        $rootScope.showSpinner = false ;
    });
});



