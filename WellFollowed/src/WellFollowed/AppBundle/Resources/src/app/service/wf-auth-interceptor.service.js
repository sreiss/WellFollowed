/**
 * Code adapté de l'article "AngularJS Token Authentication using ASP.NET Web API 2, Owin, and Identity" de Taiseer Joudeh sur CodeProject.com.
 * @author Taiseer Joudeh
 * @url http://www.codeproject.com/Articles/784106/AngularJS-Token-Authentication-using-ASP-NET-Web-A
 */
angular.module('wellFollowed').factory('$wfAuthInterceptor', function ($q, $location, localStorageService, $rootScope) {

    var _request = function (config) {

        config.headers = config.headers || {};

        var authData = localStorageService.get('authorizationData');
        if (authData) {
            config.headers.Authorization = 'Bearer ' + authData.token;
        }

        return config;
    };

    var _responseError = function (rejection) {
        if (rejection.status === 401) {
            localStorageService.remove('authorizationData');
            $rootScope.$broadcast('refreshMenu');
            $location.path('/connexion');
        } else if (rejection.status === 403) {
            $location.path('/erreur/acces-refuse');
        }
        return $q.reject(rejection);
    };

    return {
        request: _request,
        responseError: _responseError
    };

});