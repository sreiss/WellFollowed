angular.module('wellFollowed').directive('wfMenu', function($wfMenu) {
    return {
        restrict: 'E',
        templateUrl: 'common/wf-menu.html',
        link: function(scope, element, attributes) {

            scope.menuItems = $wfMenu.getMenu('main');

            scope.$on('$routeChangeSuccess', function(angularEvent, current, previous) {
                debugger;
            });
        }
    };
});