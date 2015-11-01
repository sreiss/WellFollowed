angular.module('wellFollowed', ['ngRoute', 'wfTemplates', 'wfLibTemplates', 'ui.calendar', 'LocalStorageModule', 'ui.bootstrap.modal']).config(function($routeProvider) {

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
            redirectTo: '/'
        });

})
.run(function($wfAuth) {
    $wfAuth.fillAuthData();
});