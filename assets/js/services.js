var modules = angular.module('myApp.services',[]);

modules.factory('stateService', function($rootScope,$http,appSettings){
    var factory = [] ;
    var states ;
    factory.getStates = function(){
        var promise = $http({
            method: 'GET',
            cache: true ,
            url: appSettings.serverBaseUrl + "/states"
        });
        return promise ;
    };
    return factory ;
});

modules.factory('aspirantsService', function($rootScope,$http,appSettings){
    var factory = [] ;
    var promise ;

    factory.fetchPresidentialAspirants = function(){
        promise = $http({
            method: 'GET',
            cache: true ,
            url: appSettings.serverBaseUrl + "/aspirant/presidential"
        });
        return promise ;
    };

    factory.fetchGuberAspriants = function(stateId){
        promise = $http({
            method: 'GET',
            cache: true ,
            url: appSettings.serverBaseUrl + "/aspirant/gubernatorial/" + stateId
        });
        return promise ;
    };

    return factory ;
});