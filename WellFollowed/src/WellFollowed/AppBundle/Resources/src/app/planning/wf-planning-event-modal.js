angular.module('wellFollowed').directive('wfPlanningEventModal', function($wfEvent) {
    return {
        restrict: 'E',
        templateUrl: 'planning/wf-planning-event-modal.html',
        scope: {
            close: '=',
            cancel: '&',
            data: '=?'
        },
        link: function(scope, element, attributes) {

            scope.event = scope.data.event || {};

            scope.createEvent = function() {
                $wfEvent.createEvent(scope.event).then(function(result) {
                    scope.close(result.data);
                });
            };

            scope.deleteEvent = function() {
                $wfEvent.deleteEvent(scope.event.id).then(function() {
                    scope.close(scope.event);
                });
            };
        }
    };
});