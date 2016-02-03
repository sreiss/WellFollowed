/**
 * Code adapté de l'article "AngularJS Token Authentication using ASP.NET Web API 2, Owin, and Identity" de Taiseer Joudeh sur CodeProject.com.
 * @author Taiseer Joudeh
 * @url http://www.codeproject.com/Articles/784106/AngularJS-Token-Authentication-using-ASP-NET-Web-A
 */
angular.module('wellFollowed').factory('$wfAuth', function ($http, $q, localStorageService, wfAuthSettings, $state) {
    var serviceBase = wfAuthSettings.apiUrl + '/';
    var _baseUrl = wfAuthSettings.apiUrl + '/api/user';
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

        return $http.post(serviceBase + 'token', data, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (response) {

            var scopes = response.data.scope.split(' ');

            localStorageService.set('authorizationData', {
                token: response.data.access_token,
                username: loginData.username,
                scopes: scopes
            });

            _authentication.isAuth = true;
            _authentication.username = loginData.username;
            _authentication.scopes = scopes;

            return loginData.username;
        }, function (response) {
            _logout();
            return $q.reject(response);
        }).then(function (username) {
            $http.get(_baseUrl + '/' + username)
                .then(function(response) {
                    localStorageService.set('currentUser', response.data);
                });
        });

    };

    var _logout = function () {

        localStorageService.remove('authorizationData');
        localStorageService.remove('currentUser');

        _authentication.isAuth = false;
        _authentication.username = "";
        _authentication.scopes = [];

        $state.go('home');
    };

    var _fillAuthData = function () {

        var authData = localStorageService.get('authorizationData');
        if (authData) {
            _authentication.isAuth = true;
            _authentication.username = authData.username;
            _authentication.scopes = authData.scopes;
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