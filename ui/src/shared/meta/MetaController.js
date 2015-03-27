'use strict';

/**
 * @ngInject
 */
function MetaController(User, $state) {
  var vm = this;

  vm.isLoggedIn = isLoggedIn;
  vm.logout = logout;

  function isLoggedIn() {
    return User.isLoggedIn();
  }

  function logout() {
    User.logout();
    $state.go('security.login');
  }
}


module.exports = MetaController;
