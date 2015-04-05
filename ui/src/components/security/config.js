'use strict';

module.exports = {
  'security': {
    abstract: true
  },
  'security.login': {
    url: '/login',
    params: {
      auth: false
    },
    views: {
      'main@': {
        templateUrl: '/views/security/login.html',
        controller: 'LoginController as loginVm'
      }
    }
  },
  'security.registration': {
    url: '/register',
    params: {
      auth: false
    },
    views: {
      'main@': {
        templateUrl: '/views/security/registration.html',
        controller: 'RegistrationController as registrationVm'
      }
    }
  },
  'security.confirm': {
    url: '/confirm/{token:[\\w-_]{43}}',
    params: {
      auth: false
    },
    views: {
      'main@': {
        templateUrl: '/views/security/confirm.html',
        controller: 'ConfirmController as confirmVm'
      }
    }
  }
};
