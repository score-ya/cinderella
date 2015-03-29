'use strict';
/**
 * @ngInject
 */
function Security($http, User) {

  return {
    login: login
  };

  ////////////

  function login(data) {
    return $http.post('/api/login', data).success(function(data) {
      User.setToken(data.token);
      User.setApiKey(data.data.apiKey);
    });
  }
}

module.exports = Security;
