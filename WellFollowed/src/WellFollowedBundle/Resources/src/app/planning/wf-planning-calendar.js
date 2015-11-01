angular.module('wellFollowed').directive('wfPlanningCalendar', function($wfEvent, $wfModal) {
    return {
        restrict: 'E',
        templateUrl: 'planning/wf-planning-calendar.html',
        controller: function($scope) {

            $wfEvent.getEvents()
                .then(function(data) {
                    debugger;
                });

            $scope.eventSources = [$scope.events];

            $scope.uiConfig = {
                calendar: {
                    lang: 'fr',
                    dayClick: function(date, jsEvent, view) {
                        $wfModal.open($scope, '<wf-planning-event-modal></wf-planning-event-modal>');
                    }
                }
            };

        }
    };
});