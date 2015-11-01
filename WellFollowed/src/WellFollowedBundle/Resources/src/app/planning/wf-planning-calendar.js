angular.module('wellFollowed').directive('wfPlanningCalendar', function($wfEvent, $wfModal, wfCrudTypes) {
    return {
        restrict: 'E',
        templateUrl: 'planning/wf-planning-calendar.html',
        controller: function($scope) {

            $scope.events = [];

            $wfEvent.getEvents()
                .then(function(result) {
                    angular.merge($scope.events, result.data);
                });

            $scope.eventSources = [$scope.events];

            var commonModalOptions = {
                scope: $scope,
                directiveName: 'wf-planning-event-modal'
            };

            $scope.uiConfig = {
                calendar: {
                    lang: 'fr',
                    dayClick: function(date, jsEvent, view) {
                        $wfModal.open(angular.extend(commonModalOptions, {
                            data: {
                                date: date,
                                jsEvent: jsEvent,
                                view: view,
                                type: wfCrudTypes.create
                            }
                        }));
                    },
                    eventClick: function(event, jsEvent, view) {
                        $wfModal.open(angular.extend(commonModalOptions, {
                            data: {
                                jsEvent: jsEvent,
                                view: view,
                                event: event,
                                type: wfCrudTypes.read
                            }
                        }));
                    }
                }
            };

        }
    };
});