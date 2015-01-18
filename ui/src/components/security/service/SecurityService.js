'use strict';
/**
 * @ngInject
 */
module.exports = function($http, UserService) {
  this.login = function(data) {
    return $http.post('/api/login', data).success(function(data) {
      UserService.setToken(data.token);
    });
  }
};
