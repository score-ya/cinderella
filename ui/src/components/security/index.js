'use strict';

var angular = require('angular');
var RoutingConfig = require('./config');
var LoginController = require('./controller/LoginController');
var Security = require('./service/Security');

module.exports = angular
  .module('security', [])
  .controller('LoginController', LoginController)
  .factory('Security', Security)
  .config(function ($stateProvider, $translatePartialLoaderProvider) {
    angular.forEach(RoutingConfig, function (config, name) {
      $stateProvider.state(name, config);
    });
    $translatePartialLoaderProvider.addPart('security');
  })
  .run(function ($rootScope, $state, User) {
    $rootScope.$on('$stateChangeStart', function (e, to) {
      if (to.name !== 'security.login' && User.isLoggedIn() === false) {
        e.preventDefault();
        $state.go('security.login');
      }
      if (to.name === 'security.login' && User.isLoggedIn() === true) {
        e.preventDefault();
        $state.go('template.overview');
      }
    });
  });

