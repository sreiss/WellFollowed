angular.module('wellFollowed').directive('wfApp', function($wfAuth) {
   return {
       restrict: 'E',
       templateUrl: 'common/wf-app.html',
       controller: function($scope) {

           $scope.showErrors = true;
           $scope.authentication = $wfAuth.authentication;

           this.getAuthentication = function() {
               return $scope.authentication;
           };

           this.showErrors = function(show) {
               $scope.showErrors = show;
           };

           $scope.$on('stateChangeSuccess', function() {
               $scope.showErrors = true;
           });

       }
   }
});