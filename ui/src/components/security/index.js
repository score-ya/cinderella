'use strict';

var angular = require('angular');
var RoutingConfig = require('./config');

module.exports = angular.module('security', []);

angular.module('security').controller("LoginController", require('./controller/LoginController'));
angular.module('security').service("SecurityService", require('./service/SecurityService'));
angular.module('security').config(function ($stateProvider, $translatePartialLoaderProvider) {
  angular.forEach(RoutingConfig, function (config, name) {
    $stateProvider.state(name, config)
  });
  $translatePartialLoaderProvider.addPart('security');
});
angular.module('security').run(function ($rootScope, $state, UserService) {
  $rootScope.$on('$stateChangeStart', function (e, to) {
    if (to.name !== 'security.login' && UserService.isLoggedIn() === false) {
      e.preventDefault();
      $state.go('security.login');
    }
    if (to.name === 'security.login' && UserService.isLoggedIn() === true) {
      e.preventDefault();
      $state.go('template.overview');
    }
  });
});

