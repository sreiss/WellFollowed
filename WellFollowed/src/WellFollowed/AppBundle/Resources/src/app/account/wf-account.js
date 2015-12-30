angular.module('wellFollowed').directive('wfAccount', function($wfAuth) {
   return {
       restrict: 'E',
       templateUrl: 'account/wf-account.html',
       require: '^wfApp',
       link: function(scope, element, attributes, wfApp) {

           var unregister = scope.$watch(function() {
               return $wfAuth.getCurrentUser();
           }, function(user) {
               if (!!user) {
                   scope.user = user;
                   unregister();
               }
           });

           scope.previousState = wfApp.getPreviousState().name || 'sensor';

       }
   }
});