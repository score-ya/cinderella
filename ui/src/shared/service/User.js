'use strict';

var angular = require('angular');

/**
 * @ngInject
 */
function User(CacheFactory) {

  var userData = CacheFactory('userData', {storageMode: 'sessionStorage'});

  return {
    setToken: setToken,
    setApiKey: setApiKey,
    getToken: getToken,
    getApiKey: getApiKey,
    isLoggedIn: isLoggedIn,
    logout: logout
  };

  ////////////

  function setToken(token) {
    userData.put('jwt_token', token);
  }

  function setApiKey(apiKey) {
    userData.put('api_key', apiKey);
  }

  function getToken() {
    return userData.get('jwt_token');
  }

  function getApiKey() {
    return userData.get('api_key');
  }

  function isLoggedIn() {
    return angular.isDefined(userData.get('jwt_token'));
  }

  function logout() {
    userData.removeAll();
  }
}

module.exports = User;
