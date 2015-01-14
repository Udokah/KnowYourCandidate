var controllers = angular.module('myApp.controllers',[]);

controllers.controller('MainController', function($rootScope,$scope,$window,$location,$localStorage,appSettings){
    $scope.appSettings = appSettings ;

    $scope.goBack = function(){
        $window.history.back();
    };

    /* Hide Url bar in mobile devices */
    $scope.$on('$viewContentLoaded', function(){
        window.scrollTo(0,1);
    });

});

controllers.controller('StartController', function($scope,$location){
    $scope.start = function(){
        $scope.animateMe = true ;
        $location.path('/select-type');
    }
});

controllers.controller('SelectController', function($scope){

});

controllers.controller('StateController', function($scope,$location,stateService,$localStorage,$interval){
    $scope.states = {}
    $scope.statesLoaded = false ;
    $scope.loadStates = function(){
        if(!$scope.statesLoaded){
            var promise = stateService.getStates() ;
            promise.success(function(data,status,headers,config){
                $scope.states = data ;
                $scope.statesLoaded = true ;
            });
        }
    };

    $scope.linkClicked = function(state){
         $localStorage.currentStateId = state.sid ;
         $location.path("/gubernatorial/aspirants/" + state.name);
    };

    $interval(function(){
        $scope.loadStates();
    },800,1,false);
});


controllers.controller('GubAspController', function($scope,$location,$stateParams,aspirantsService,$localStorage){
    var promise = aspirantsService.fetchGuberAspriants($localStorage.currentStateId);
    promise.success(function(data,status,headers,config){
        $scope.aspirants = data ;
    });

    $scope.goToAspirantProfileGub = function(person){
        $localStorage.currentAspirant = person ;
        $location.path("/gubernatorial/aspirants/" + $stateParams.state + "/" + person.nameUrl);
    };

});

controllers.controller('PresAspController', function($scope,aspirantsService,$localStorage,$location){
    var promise = aspirantsService.fetchPresidentialAspirants();
    promise.success(function(data,status,headers,config){
        $scope.aspirants = data ;
    });

    $scope.goToAspirantProfilePres = function(person){
        $localStorage.currentAspirant = person ;
        $location.path("/presidential/aspirants/" + person.nameUrl);
    };

});

controllers.controller('ProfileController', function($scope,$localStorage){
    $scope.person = $localStorage.currentAspirant ;
    $scope.serverBaseUrl = serverBaseUrl ;
});
