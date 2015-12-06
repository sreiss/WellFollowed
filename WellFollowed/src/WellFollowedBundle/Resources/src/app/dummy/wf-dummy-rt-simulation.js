angular.module('wellFollowed').directive('wfDummyRtSimulation', function(wfAuthSettings) {
    return {
        restrict: 'E',
        scope: {
            sensorName: '@'
        },
        controller: function($scope, $interval) {
            var websocket = WS.connect(wfAuthSettings.websocketUrl);
            var wsSession = null;

            websocket.on('socket/connect', function (session) {
                wsSession = session;
                console.log('Websocket connection success.');

                $interval(function() {
                    var val = Math.floor((Math.random() * 10) + 9);
                    console.log('Value ' + val + ' sent to ' + $scope.sensorName);
                    wsSession.publish('sensor/data/' + $scope.sensorName, {date: new Date(), val: val});
                }, 1000);
            });

            websocket.on('socket/disconnect', function (error) {
                wsSession = null;
            });
        },
        link: function (scope, element, attributes) {

        }
    };
});