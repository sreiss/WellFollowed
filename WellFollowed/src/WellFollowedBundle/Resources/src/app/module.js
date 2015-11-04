angular.module('wellFollowed', ['ngRoute', 'ngMessages', 'wfTemplates', 'wfLibTemplates', 'ui.calendar', 'LocalStorageModule', 'ui.bootstrap.modal']).config(function($routeProvider, $httpProvider) {

    var formatDate = function(data) {
        if (!!data) {
            for (var key in data) {
                if (data[key] instanceof Date)
                    data[key] = moment(data[key]);

                if (!!data[key].format)
                    data[key] = data[key].format('YYYY-MM-DD[T]HH:mm:ssZZ');
                else if (typeof data[key] === 'object')
                    formatDate(data[key]);
            }
        }
        return data;
    };

    $httpProvider.defaults.transformRequest.unshift(formatDate);

    // Enregistrement des routes de l'application.
    // Si un attribut "name" est renseigné, l'élément sera ajouté automatiquement au menu.
    // L'attribut "template" contiendra toujours une directive englobant l'ensemble d'une page.
    $routeProvider
        .when('/sensor', {
            template: '<wf-sensor></wf-sensor>',
            name: 'Capteur'
        })
        .when('/calendrier', {
            template: '<wf-planning></wf-planning>',
            name: 'Calendrier'
        })
        .when('/account', {
            template: '<wf-account></wf-account>',
            name: 'Compte'
        })
        .otherwise({
            redirectTo: '/sensor'
        });

})
.run(function($wfAuth, $rootScope, wfCrudTypes) {
    $rootScope.wfCrudTypes = wfCrudTypes;
    $wfAuth.fillAuthData();
});