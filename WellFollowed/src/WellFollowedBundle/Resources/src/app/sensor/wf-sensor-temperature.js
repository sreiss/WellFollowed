angular.module('wellFollowed').directive('wfSensorTemperature', function() {
    return {
        restrict: 'E',
        templateUrl: 'sensor/wf-sensor-temperature.html',
        scope: {
            sensor: '='
        },
        require: '^wfSensor',
        link: function(scope, element, attributes, wfSensor) {
            var session = wfSensor.getWsSession();

            session.subscribe('sensor/' + scope.sensor.name, function(uri, payload) {
                console.log(payload);
            });
        }
    };
});