angular.module('wellFollowed').factory('$wfModal', function($uibModal) {

    var _open = function(scope, directive) {
        var modalInstance = $uibModal.open({
            scope: scope,
            template: directive,
            size: 'modal-lg'
        });

        return modalInstance.result;
    };

    return {
        open: _open
    };
});