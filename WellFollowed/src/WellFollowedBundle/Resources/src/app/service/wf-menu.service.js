angular.module('wellFollowed').factory('$wfMenu', function() {
    var _menus = {
        'main': [
            { name: 'Sensor', state: 'sensor', right: 'ReadSensor' },
            { name: 'Calendrier', state: 'calendar', right: 'ReadCalendar' },
            { name: 'Compte', state: 'account', right: 'ReadAccount' },
            { name: 'Administration', right: 'ReadAdmin', items:
                [
                    { name: "Types d'établissement", state: 'admin.institutionTypes', right: 'ReadInstitutionTypeList'}
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