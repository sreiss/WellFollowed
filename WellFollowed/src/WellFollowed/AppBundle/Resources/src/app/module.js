angular.module('wellFollowed', ['ui.router', 'ngMessages', 'wfTemplates', 'wfLibTemplates', 'ui.calendar', 'LocalStorageModule', 'ui.bootstrap.modal', 'ui.bootstrap.alert', 'angular-loading-bar']).config(function($stateProvider, $urlRouterProvider, $httpProvider, cfpLoadingBarProvider) {

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

    $httpProvider.interceptors.push('$wfAuthInterceptor');

    $httpProvider.interceptors.push(function($q, $rootScope) {
        var errorHandler = function(rejection) {
            $rootScope.$broadcast('wfError', rejection.message);

            return $q.reject(rejection);
        };

        return {
            'requestError': errorHandler,
            'responseError': errorHandler
        };
    });

    // Enregistrement des routes de l'application.
    // Si un attribut "name" est renseigné, l'élément sera ajouté automatiquement au menu.
    // L'attribut "template" contiendra toujours une directive englobant l'ensemble d'une page.
    $stateProvider
        .state('login', {
            url: '/connexion',
            template: '<wf-login></wf-login>'
        })
        .state('sensor', {
            url: '/',
            template: '<wf-sensor></wf-sensor>'
        })
        .state('calendar', {
            url: '/calendrier',
            template: '<wf-planning></wf-planning>'
        })
        .state('account', {
            url: '/compte',
            template: '<wf-account></wf-account>'
        })
        .state('subscription', {
            url: '/compte/inscription',
            template: '<wf-account-create></wf-account-create>'
        })
        .state('rtSimulation', {
            url: '/dummy/rtSimulation/:sensorName',
            template: function(params) { return '<wf-dummy-rt-simulation sensor-name="' + params.sensorName + '"></wf-dummy-rt-simulation>'; }
        })
        .state('admin', {
            url: '/admin',
            abstract: true,
            template: '<wf-admin></wf-admin>'
        })
        .state('admin.institutionTypes', {
            url: '/institution-types',
            template: '<wf-admin-institution-types></wf-admin-institution-types>'
        })
        .state('admin.institutionType', {
            url: '/institution-type/:id',
            template: function(params) { return '<wf-admin-institution-type institution-type-id="' + params.id + '"></wf-admin-institution-type>'; }
        })
        .state('admin.institutions', {
            url: '/institutions',
            template: '<wf-admin-institutions></wf-admin-institutions>'
        })
        .state('admin.institution', {
            url: '/institution/:id',
            template: function(params) { return '<wf-admin-institution institution-id="' + params.id + '"></wf-admin-institution>'; }
        });

    $urlRouterProvider.otherwise('/');

    cfpLoadingBarProvider.includeSpinner = false;
})
.run(function($wfAuth, $rootScope, wfCrudTypes) {
    $rootScope.wfCrudTypes = wfCrudTypes;
    $wfAuth.fillAuthData();
});