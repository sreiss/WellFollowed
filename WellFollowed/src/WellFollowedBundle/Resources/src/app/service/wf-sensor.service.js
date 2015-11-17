angular.module('wellFollowed').factory('$wfSensor', function($http, wfAuthSettings) {

    var _baseUrl = wfAuthSettings.apiUrl + '/api/sensor';

    var _getSensors = function(filter) {
        return $http.get(_baseUrl, {params: filter});
    };

    var _getSensor = function(name) {
        return $http.get(_baseUrl + '/' + name);
    };

    return {
        getSensors: _getSensors,
        getSensor: _getSensor
    };
});