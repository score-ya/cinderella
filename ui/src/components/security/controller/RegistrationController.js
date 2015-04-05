'use strict';

/**
 * @ngInject
 */
function RegistrationController(Security, $state) {
  var vm = this;

  vm.user = {};

  vm.register = register;

  function register() {
    Security.register(vm.user).then(function () {
      //todo show info text message?
      $state.go('security.login');
    });
  }

}

module.exports = RegistrationController;
