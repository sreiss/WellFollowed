angular.module('wellFollowed').directive('wfApp', function($wfAuth, wfAlertTypes) {
   return {
       restrict: 'E',
       templateUrl: 'common/wf-app.html',
       controller: function($scope, $location) {

           $scope.alerts = [];
           $scope.showErrors = true;
           $scope.authentication = $wfAuth.authentication;

           this.getAuthentication = function() {
               return $scope.authentication;
           };

           this.showErrors = function(show) {
               $scope.showErrors = show;
           };

           this.addSuccess = function(message) {
                $scope.alerts.unshift({
                    type: wfAlertTypes.success,
                    message: message
                });
           };

           $scope.$on('stateChangeSuccess', function() {
               $scope.showErrors = true;
           });

           $scope.logOut = function() {
               $wfAuth.logout();
               $location.path('/connexion');
           }

       }
   }
});