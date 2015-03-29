'use strict';

/**
 * @ngInject
 */
function LoginController(Security, $state) {
  var vm = this;

  vm.loginData = {};
  vm.login = login;

  function login() {
    Security.login(vm.loginData).then(function () {
      $state.go('template.overview');
    });
  }
}

module.exports = LoginController;
