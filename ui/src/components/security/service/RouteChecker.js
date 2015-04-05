'use strict';
/**
 * @ngInject
 */
function RouteChecker($rootScope, $state, User) {

  $rootScope.$on('$stateChangeStart', function (e, to) {

    if (to.params.auth === true && User.isLoggedIn() === false) {
      e.preventDefault();
      $state.go('security.login');
    }
    if (to.params.auth === false && User.isLoggedIn() === true) {
      e.preventDefault();
      $state.go('template.overview');
    }
  });
}

module.exports = RouteChecker;
