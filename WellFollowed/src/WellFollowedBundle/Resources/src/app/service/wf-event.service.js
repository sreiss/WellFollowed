angular.module('wellFollowed').factory('$wfEvent', function($http, wfAuthSettings) {

    var _baseUrl = wfAuthSettings.apiUrl + '/api/event';

    var _createEvent = function(event) {
        return $http.post(_baseUrl, event);
    };

    var _getEvents = function(filter) {
        return $http.get(_baseUrl, { params: filter });
    };

    var _deleteEvent = function(id) {
        return $http.delete(_baseUrl + '/' + id);
    };

    return {
        getEvents: _getEvents,
        createEvent: _createEvent,
        deleteEvent: _deleteEvent
    };

});