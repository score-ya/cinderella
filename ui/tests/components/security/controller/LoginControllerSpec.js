'use strict';

var LoginController = require('../../../../src/components/security/controller/LoginController');

describe('Components:Security:Controller:LoginController', function () {

  var createController, $q, $rootScope;

  var $state = jasmine.createSpyObj('$state', ['go']);
  var Security = jasmine.createSpyObj('Security', ['login']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      $q = $injector.get('$q');
      $rootScope = $injector.get('$rootScope');
      createController = function () {
        return $controller(LoginController, {'Security': Security, '$state': $state});
      };

    });
  });

  it('should log in an user and redirect after success to template overview', function () {

    var controller = createController();
    controller.loginData = 'data';

    Security.login.and.returnValue($q.when('true'));

    controller.login();

    $rootScope.$apply();

    expect($state.go).toHaveBeenCalledWith('template.overview');

  });

});