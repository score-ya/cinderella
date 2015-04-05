'use strict';

var RegistrationController = require('../../../../src/components/security/controller/RegistrationController');

describe('Components:Security:Controller:RegistrationController', function () {

  var createController,
      $q,
      $rootScope,
      $state,
      Security;

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      $state = jasmine.createSpyObj('$state', ['go']);
      Security = jasmine.createSpyObj('Security', ['register']);
      var $controller = $injector.get('$controller');
      $q = $injector.get('$q');
      $rootScope = $injector.get('$rootScope');
      createController = function () {
        return $controller(RegistrationController, {'Security': Security, '$state': $state});
      };

    });
  });
  it('should register a new user', function () {

    Security.register.and.returnValue($q.when(true));

    var controller = createController();

    controller.register();
    $rootScope.$apply();

    expect($state.go).toHaveBeenCalledWith('security.login');
  });
});