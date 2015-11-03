angular.module('wellFollowed', ['ngRoute', 'ngMessages', 'wfTemplates', 'wfLibTemplates', 'ui.calendar', 'LocalStorageModule', 'ui.bootstrap.modal']).config(function($routeProvider) {

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