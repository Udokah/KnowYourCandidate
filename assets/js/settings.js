var settings = angular.module('myApp.settings',[]);

/* Set all values for the app */
settings.factory('appSettings', function(){
    var configurations = {} ;
    configurations.viewsDir = 'views/' ;
    configurations.serverBaseUrl = 'http://localhost/KYC/admin' ;
    //configurations.serverBaseUrl = 'http://192.168.43.100/KYA' ;
    configurations.templatesDir = 'templates/' ;
    return configurations ;
});