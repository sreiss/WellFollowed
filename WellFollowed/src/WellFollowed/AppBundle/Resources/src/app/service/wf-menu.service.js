angular.module('wellFollowed').factory('$wfMenu', function($wfAuth) {
    var _menus = {
        'main': [
            { name: 'Capteurs', state: 'sensor', right: 'access_sensor' },
            { name: 'Calendrier', state: 'calendar', right: 'access_calendar' },
            { name: 'Administration', right: 'access_admin', items:
                [
                    { name: "Établissements", state: 'admin.institutions', right: 'access_institution' },
                    { name: "Types d'établissement", state: 'admin.institutionTypes', right: 'access_institution_type'},
                    { name: "Utilisateurs", state: 'admin.users', right: 'access_user' }
                ]
            }
        ],
        'noauth': [
            { name: 'S\'inscrire', state: 'subscription'},
            { name: 'Se connecter', state: 'login'}
        ]
    };

    var _getMenu = function(id) {
        var menu = _menus[id];
        //if (id != 'noauth') {
        //    for (var i = 0; i < _menus[id].length; i++) {
        //        var right = _menus[id][i].right;
        //        if ((!!right && $wfAuth.authentication.scopes.indexOf(right) > 0) || !right) {
        //            menu.push(_menus[id][i]);
        //        }
        //    }
        //
        //} else {
        //    menu = _menus[id];
        //}
        return menu || [];
    };

    return {
        getMenu: _getMenu
    };
});