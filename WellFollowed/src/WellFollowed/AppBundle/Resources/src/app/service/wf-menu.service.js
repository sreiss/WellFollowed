angular.module('wellFollowed').factory('$wfMenu', function() {
    var _menus = {
        'main': [
            { name: 'Sensor', state: 'sensor', right: 'ReadSensor' },
            { name: 'Calendrier', state: 'calendar', right: 'ReadCalendar' },
            { name: 'Administration', right: 'ReadAdmin', items:
                [
                    { name: "Établissements", state: 'admin.institutions', right: 'ReadInstitutions' },
                    { name: "Types d'établissement", state: 'admin.institutionTypes', right: 'ReadInstitutionTypes'}
                ]
            }
        ],
        'noauth': [
            { name: 'S\'inscrire', state: 'subscription'},
            { name: 'Se connecter', state: 'login'}
        ]
    };

    var _getMenu = function(id, auth) {
        return _menus[id] || [];
    };

    return {
        getMenu: _getMenu
    };
});