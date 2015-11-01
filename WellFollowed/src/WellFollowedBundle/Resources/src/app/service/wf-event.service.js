angular.module('wellFollowed').factory('$wfEvent', function($http, wfAuthSettings) {

    var _baseUrl = wfAuthSettings.apiUrl + '/api/event';

    var _getEvents = function(filter) {
        return $http.get(_baseUrl, { param: filter });
    };

    var _createEvent = function(event) {
        return $http.post(_baseUrl, event);
    };

    return {
        getEvents: _getEvents,
        createEvent: _createEvent
    };

});