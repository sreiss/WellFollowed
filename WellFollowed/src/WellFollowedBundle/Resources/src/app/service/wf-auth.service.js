/**
 * Code adapté de l'article "AngularJS Token Authentication using ASP.NET Web API 2, Owin, and Identity" de Taiseer Joudeh sur CodeProject.com.
 * @author Taiseer Joudeh
 * @url http://www.codeproject.com/Articles/784106/AngularJS-Token-Authentication-using-ASP-NET-Web-A
 */
angular.module('wellFollowed').factory('$wfAuth', function($http, $q, localStorageService, wfAuthSettings) {
    var serviceBase = wfAuthSettings.apiUrl + '/';
    var _baseUrl = wfAuthSettings.apiUrl + '/api/user';
    var authServiceFactory = {};

    var _authentication = {
        isAuth: false,
        userName : ""
    };

    var _createUser = function (registration) {

        _logout();

        return $http.post(_baseUrl, registration).then(function (response) {
            return response;
        });
    };

    var _login = function (loginData) {

        var data = "grant_type=password&username=" +
            loginData.username + "&password=" + loginData.password + "&client_id=user&scope=readsensor";
        debugger;
        var deferred = $q.defer();

        $http.post(serviceBase + 'token', data, { headers:
        { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function (response) {

            localStorageService.set('authorizationData',
                { token: response.access_token, username: loginData.username });

            _authentication.isAuth = true;
            _authentication.username = loginData.username;

            deferred.resolve(response);

        }).error(function (err, status) {
            _logout();
            deferred.reject(err);
        });

        return deferred.promise;
    };

    var _logout = function () {

        localStorageService.remove('authorizationData');

        _authentication.isAuth = false;
        _authentication.username = "";
    };

    var _fillAuthData = function () {

        var authData = localStorageService.get('authorizationData');
        if (authData)
        {
            _authentication.isAuth = true;
            _authentication.userName = authData.username;
        }
    };

    return {
        createUser: _createUser,
        login: _login,
        logout: _logout,
        fillAuthData: _fillAuthData,
        authentication: _authentication
    };
});