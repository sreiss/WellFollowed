angular.module('wellFollowed').directive('wfPlanningCalendar', function($wfEvent, $wfModal, wfCrudTypes, uiCalendarConfig) {
    return {
        restrict: 'E',
        templateUrl: 'planning/wf-planning-calendar.html',
        controller: function($scope) {

            $scope.events = [];

            $scope.eventsF = function (start, end, timezone, callback) {
                var filter = {
                    start: start.toDate(),
                    end: end.toDate()
                };

                $wfEvent.getEvents(filter)
                    .then(function (result) {
                        angular.merge($scope.events, result.data);
                        uiCalendarConfig.calendars
                            .eventsCalendar
                            .fullCalendar('refresh');
                    });
            };

            var commonModalOptions = {
                scope: $scope,
                directiveName: 'wf-planning-event-modal'
            };

            $scope.uiConfig = {
                calendar: {
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    lang: 'fr',
                    dayClick: function(date, jsEvent, view) {
                        $wfModal.open(angular.extend(commonModalOptions, {
                                data: {
                                    event: {
                                        start: date,
                                        end: date.add(2, 'hour'),
                                        title: 'Réservation'
                                    },
                                    jsEvent: jsEvent,
                                    view: view,
                                    type: wfCrudTypes.create
                                }
                            }))
                            .then(function(event) {
                                $scope.events.push(event);
                            });
                    },
                    eventClick: function(event, jsEvent, view) {
                        $wfModal.open(angular.extend(commonModalOptions, {
                                data: {
                                    event: {
                                        id: event.id,
                                        start: event.start,
                                        end: event.start.add(2, 'hour'),
                                        title: event.title
                                    },
                                    jsEvent: jsEvent,
                                    view: view,
                                    type: wfCrudTypes.read,
                                    title: 'Réservation'
                                }
                            }))
                            .then(function(deletedId) {
                                $scope.events.splice(_.findIndex({id: deletedId}), 1);
                                uiCalendarConfig.calendars
                                    .eventsCalendar
                                    .fullCalendar('refresh');
                            });
                    }
                }
            };

            $scope.eventSources = [$scope.eventsF, $scope.events];
        }
    };
});