angular.module('wellFollowed').directive('wfAccount', function($wfAuth) {
   return {
       restrict: 'E',
       templateUrl: 'account/wf-account.html',
       link: function(scope, element, attributes) {

           var unregister = scope.$watch(function() {
               return $wfAuth.getCurrentUser();
           }, function(user) {
               if (!!user) {
                   scope.user = user;
                   unregister();
               }
           });

       }
   }
});