var directives = angular.module('myApp.directives', []);

function translateSquare(index) {
    return (index || 0) * 250;
}


/* Site Header */
directives.directive('siteHeader',function(appSettings){
    return {
        restrict: 'E',
        replace: true,
        templateUrl: appSettings.templatesDir + 'header.html'
    };
});

/* Ajax Loader */
directives.directive('ajaxLoader', function(appSettings){
    return{
        restrict: 'E',
        replace: true,
        template: "<div class='ajaxLoader' ng-show='showSpinner'><img src='assets/img/ajaxloader.gif' alt='loading' /></div>"
    };
});


directives.directive('square', function($famous){
    var Transform = $famous['famous/core/Transform'];
    var Transitionable = $famous['famous/transitions/Transitionable'];
    var SnapTransition = $famous['famous/transitions/SnapTransition'];

    var flipOut = Transform.rotateZ(Math.PI / 2);
    var flipIn  = Transform.inverse(flipOut);

    return {
        restrict: 'A',
        priority: 3,
        link: function(scope, element, attrs) {
            var transform = new Transitionable(Transform.multiply(
                Transform.translate(translateSquare(scope.$index % 3), Math.floor(scope.$index / 3) * 60 + 40, 0),
                flipOut
            ));

            var opacity = new Transitionable(0);

            function enter() {
                transform.set(Transform.multiply(transform.get(), flipIn), {
                    duration: 250,
                    transition: SnapTransition
                });

                opacity.set(1, {duration: 250, curve: 'easeOut'});

                return 250;
            };

            function leave() {
                transform.set(Transform.multiply(transform.get(), flipOut), {
                    duration: 250,
                    transition: SnapTransition
                });

                opacity.set(0, {duration: 250, curve: 'easeIn'});

                return 250;
            };

            function halt() {
                scope.transform.halt();
            };

            angular.extend(scope, {
                enter: enter,
                leave: leave,
                halt: halt,
                opacity: opacity,
                transform: transform
            });
        }
    }
});
