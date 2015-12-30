angular.module('wellFollowed').directive('wfMenu', function($wfMenu) {

    var _menuItems = function(scope) {
        if (scope.authentication.isAuth)
            scope.menuItems = $wfMenu.getMenu('main');
        else
            scope.menuItems = $wfMenu.getMenu('noauth');
    };

    return {
        restrict: 'E',
        templateUrl: 'common/wf-menu.html',
        link: function(scope, element, attributes, wfApp) {

            _menuItems(scope);

            scope.$on('$stateChangeSuccess', function(angularEvent, current, previous) {
                _menuItems(scope);
            });
        }
    };
});