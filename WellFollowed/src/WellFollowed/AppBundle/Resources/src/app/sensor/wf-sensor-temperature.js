angular.module('wellFollowed').directive('wfSensorTemperature', function() {
    return {
        restrict: 'E',
        templateUrl: 'sensor/wf-sensor-temperature.html',
        scope: {
            sensor: '='
        },
        require: '^wfSensor',
        controller: function($scope) {
            $scope.data = [];
        },
        link: function(scope, element, attributes, wfSensor) {
            scope.currentTemp = 0;
        }
    };
});