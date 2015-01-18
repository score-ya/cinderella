'use strict';
/**
 * @ngInject
 */
module.exports = function(DSCacheFactory) {

  var userData = DSCacheFactory('userData', {storageMode: 'sessionStorage'});

  this.setToken = function(token) {
    userData.put('jwt_token', token);
  };

  this.getToken = function() {
    return userData.get('jwt_token');
  };

  this.isLoggedIn = function() {
    return angular.isDefined(userData.get('jwt_token'))
  };

  this.logout = function() {
    userData.removeAll();
  };
};
