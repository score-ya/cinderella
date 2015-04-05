'use strict';
/**
 * @ngInject
 */
function Security($http, User) {

  return {
    login: login,
    register: register,
    confirm: confirm
  };

  ////////////

  function register(data) {
    return $http.post('/api/register', data);
  }

  function confirm(data) {
    return $http.patch('/api/confirm/' + data);
  }

  function login(data) {
    return $http.post('/api/login', data).success(function(data) {
      User.setToken(data.token);
      User.setApiKey(data.data.apiKey);
    });
  }
}

module.exports = Security;
