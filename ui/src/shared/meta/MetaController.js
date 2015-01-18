'use strict';

/**
 * @ngInject
 */
module.exports = function (UserService, $state) {
  var vm = this;

  vm.isLoggedIn = function() {
    return UserService.isLoggedIn()
  };

  vm.logout = function() {
    UserService.logout();
    $state.go('security.login');
  };
};
