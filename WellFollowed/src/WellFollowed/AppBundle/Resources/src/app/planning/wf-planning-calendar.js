angular.module('wellFollowed').directive('wfPlanningCalendar', function($wfEvent, $wfModal, wfCrudTypes, wfResponseFormats, uiCalendarConfig) {
    return {
        restrict: 'E',
        templateUrl: 'planning/wf-planning-calendar.html',
        controller: function($scope) {

            $scope.events = {
                events: []
            };
            $scope.cancelledEvents = {
                color: '#eee',
                textColor: '#999',
                events: []
            };

            $scope.eventsF = function (start, end, timezone, callback) {
                var filter = {
                    start: start.toDate(),
                    end: end.toDate(),
                    format: wfResponseFormats.formatFull
                };

                $wfEvent.getEvents(filter)
                    .success(function (result) {
                        result.map(function(event) {
                            if (event.cancelled) {
                                $scope.cancelledEvents.events.push(event);
                            } else {
                                $scope.events.events.push(event);
                            }
                        });
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
                                $scope.events.events.push(event);
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
                            .then(function(event) {
                                $scope.events.events.splice($scope.events.events.indexOf(event), 1);
                                $scope.cancelledEvents.events.push(event);
                                uiCalendarConfig.calendars
                                    .eventsCalendar
                                    .fullCalendar('refresh');
                            });
                    }
                }
            };

            $scope.eventSources = [$scope.eventsF, $scope.events, $scope.cancelledEvents];
        }
    };
});