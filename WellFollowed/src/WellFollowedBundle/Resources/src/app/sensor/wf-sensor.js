angular.module('wellFollowed').directive('wfSensor', function(wfAuthSettings) {
   return {
       restrict: 'E',
       templateUrl: 'sensor/wf-sensor.html',
       controller: function($scope) {
            $scope.hasWsSession = false;
            var websocket = WS.connect(wfAuthSettings.websocketUrl);
            var wsSession = null;

            websocket.on('socket/connect', function(session) {
                $scope.hasWsSession = true;
                wsSession = session;
                console.log('Websocket connection success.');
            });

            websocket.on('socket/disconnect', function(error) {
                $scope.hasWsSession = false;
                wsSession = null;
            });

            this.getWsSession = function() {
                return wsSession;
            };
       },
       link: function(scope, element, attributes) {
           scope.sensors = [
               {label: 'Capteur 1', name: 'sensor1', displayed: true},
               {label: 'Capteur 2', name: 'sensor2', displayed: false}
           ];
       }
   };
});