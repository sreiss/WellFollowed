angular.module('wellFollowed').directive('wfSensor', function ($wfUrl, $wfSensor) {
    return {
        restrict: 'E',
        templateUrl: 'sensor/wf-sensor.html',
        controller: function ($scope) {
            $scope.hasWsSession = false;
            var websocket = WS.connect($wfUrl.getWsUrl());
            var wsSession = null;

            websocket.on('socket/connect', function (session) {
                $scope.hasWsSession = true;
                wsSession = session;
                console.log('Websocket connection success.');
            });

            websocket.on('socket/disconnect', function (error) {
                $scope.hasWsSession = false;
                wsSession = null;
            });

            this.getWsSession = function () {
                return wsSession;
            };
        },
        link: function (scope, element, attributes) {
            scope.sensors = [];
            $wfSensor.getSensors().success(function(result) {
                scope.sensors = result;
            });
        }
    };
});