'use strict';

/**
 * @ngInject
 */
module.exports = function (SecurityService, $state) {
  var vm = this;

  vm.loginData = {};

  vm.login = function () {
    SecurityService.login(vm.loginData).then(function () {
      $state.go('template.overview');
    });
  }
};
