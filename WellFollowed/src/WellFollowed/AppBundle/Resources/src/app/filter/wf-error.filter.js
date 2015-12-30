angular.module('wellFollowed').filter('wfError', function(wfErrorCodes) {
   return function(input) {
      return wfErrorCodes[input] || wfErrorCodes['UNKNOWN_ERROR'];
   };
});