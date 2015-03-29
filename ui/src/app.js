'use strict';

var angular = require('angular');

require('angular-route');
require('angular-jwt');
require('angular-translate');
require('angular-translate-loader-partial');
require('angular-resource');
require('angular-ui-unique');
require('angular-bootstrap');
var requires = [
  'ui.router',
  'angular-jwt',
  'pascalprecht.translate',
  'ngResource',
  'ui.unique',
  'ui.bootstrap',
  require('angular-cache'),
  require('./components').name,
  require('./shared').name
];

angular.module('cinderella-ui-app', requires)
  .config(function ($httpProvider, jwtInterceptorProvider) {
    jwtInterceptorProvider.tokenGetter = ['User', function (User) {
      return User.getToken();
    }];

    $httpProvider.interceptors.push('jwtInterceptor');
  })
  .config(function ($urlRouterProvider, $locationProvider, $resourceProvider) {
    $urlRouterProvider.otherwise(function ($injector) {
      var $state, User;
      User = $injector.get('User');
      $state = $injector.get('$state');
      if (User.isLoggedIn() === true) {
        $state.go('template.overview');
      } else {
        $state.go('security.login');
      }
    });

    $resourceProvider.defaults.stripTrailingSlashes = true;

    $locationProvider.html5Mode(true).hashPrefix('!');
  })
  .config(function ($translateProvider) {

    $translateProvider.useLoader('$translatePartialLoader', {
      urlTemplate: '/i18n/{part}/{lang}.json'
    });

    // add translation table
    $translateProvider
      .registerAvailableLanguageKeys(['en', 'de'], {
        'en_*': 'en',
        'de_*': 'de'
      })
      .determinePreferredLanguage();

    /*
     The fallback language is not working ...
     $translateProvider.fallbackLanguage('en');
     The following workaround sets the preferred language to english,
     if the detection failed or the detected language is not known.
     */
    var language = $translateProvider.preferredLanguage();
    if ((language !== null) || !language.match(/(de).*/)) {
      return $translateProvider.preferredLanguage('de');
    }
  })
  .config(function ($translatePartialLoaderProvider) {

    $translatePartialLoaderProvider.addPart('default');

  });

angular.bootstrap(document, ['cinderella-ui-app']);