angular.module('wellFollowed').directive('wfMenu', function($route) {
    return {
        restrict: 'E',
        templateUrl: 'common/wf-menu.html',
        link: function(scope, element, attributes) {

            scope.menuItems = [];
            angular.forEach($route.routes, function(route) {
                if (!!route.name) {
                    scope.menuItems.push({
                        name: route.name,
                        href: route.originalPath
                    })
                }
            });

            scope.$on('$routeChangeSuccess', function(angularEvent, current, previous) {
                debugger;
            });
        }
    };
});