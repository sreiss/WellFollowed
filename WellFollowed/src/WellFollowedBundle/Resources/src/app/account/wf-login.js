angular.module('wellFollowed').directive('wfLogin', function($wfAuth, $location) {
    return {
        restrict: 'E',
        templateUrl: 'account/wf-login.html',
        require: '^wfApp',
        link: function (scope, element, attributes, wfApp) {

            wfApp.showErrors(false);

            scope.login = function() {
                $wfAuth.login({
                    username: scope.username,
                    password: scope.password
                }).then(function (result) {
                    $location.path("/calendrier");
                });
            }

        }
    };
});