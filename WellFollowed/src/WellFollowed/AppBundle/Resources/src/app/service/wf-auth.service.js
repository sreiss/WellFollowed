/**
 * Code adapté de l'article "AngularJS Token Authentication using ASP.NET Web API 2, Owin, and Identity" de Taiseer Joudeh sur CodeProject.com.
 * @author Taiseer Joudeh
 * @url http://www.codeproject.com/Articles/784106/AngularJS-Token-Authentication-using-ASP-NET-Web-A
 */
angular.module('wellFollowed').factory('$wfAuth', function ($http, $q, localStorageService, wfAuthSettings, $wfUrl, $state, $rootScope) {
    var serviceBase = $wfUrl.getApiUrl() + '/';
    var _baseUrl = $wfUrl.getApiUrl() + '/api/user';
    var authServiceFactory = {};

    var _authentication = {
        isAuth: false,
        username: "",
        scopes: []
    };

    var _createUser = function (registration) {

        _logout();

        return $http.post(_baseUrl, registration).then(function (response) {
            return response;
        });
    };

    var _login = function (loginData) {

        var data = 'grant_type=password&' +
            'username=' + loginData.username + '&' +
            'password=' + loginData.password + '&' +
            'client_id=' + wfAuthSettings.clientId + '&' +
            'client_secret=' + wfAuthSettings.clientSecret;

        return $http.post(serviceBase + 'oauth/v2/token', data, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (response) {

            localStorageService.set('authorizationData', {
                token: response.data.access_token,
                username: loginData.username
            });

            _authentication.isAuth = true;
            _authentication.username = loginData.username;

            return loginData.username;
        }, function (response) {
            _logout();
            return $q.reject(response);
        }).then(function (username) {
            $http.get(_baseUrl + '/' + username)
                .then(function(response) {
                    localStorageService.set('currentUser', response.data);
                    $rootScope.$broadcast('refreshMenu');
                });
        });

    };

    var _logout = function () {

        localStorageService.remove('authorizationData');
        localStorageService.remove('currentUser');

        _authentication.isAuth = false;
        _authentication.username = "";

        $state.go('home');
    };

    var _fillAuthData = function () {

        var authData = localStorageService.get('authorizationData');
        if (authData) {
            _authentication.isAuth = true;
            _authentication.username = authData.username;
        }
    };

    var _getCurrentUser = function() {
        return localStorageService.get('currentUser');
    };

    return {
        createUser: _createUser,
        login: _login,
        logout: _logout,
        fillAuthData: _fillAuthData,
        authentication: _authentication,
        getCurrentUser: _getCurrentUser
    };
});