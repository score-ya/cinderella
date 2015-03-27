'use strict';

module.exports = {
  'security': {
    abstract: true
  },
  'security.login': {
    url: '/login',
    views: {
      'main@': {
        templateUrl: '/views/security/login.html',
        controller: 'LoginController as vm'
      }
    }
  }
};
