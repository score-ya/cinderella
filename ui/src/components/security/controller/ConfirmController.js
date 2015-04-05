'use strict';

/**
 * @ngInject
 */
function ConfirmController(Security, $state) {
  var vm = this;

  vm.inProgress = true;
  vm.success = false;
  Security
    .confirm($state.params.token)
    .then(function () {
      //todo show info text message?
      vm.inProgress = !vm.inProgress;
      vm.success = !vm.success;
    })
    .catch(function() {
      vm.inProgress = !vm.inProgress;
    });

}

module.exports = ConfirmController;
