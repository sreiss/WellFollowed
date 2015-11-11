angular.module('wellFollowed').factory('$wfMenu', function() {
    var _menus = {
        'main': [
            { name: 'Sensor', state: 'sensor', right: 'ReadSensor' },
            { name: 'Calendrier', state: 'calendar', right: 'ReadCalendar' },
            { name: 'Compte', state: 'account', right: 'ReadAccount' }
        ]
    };

    var _getMenu = function(id) {
        return _menus[id] || [];
    };

    return {
        getMenu: _getMenu
    };
});