'use strict';

var ConfirmController = require('../../../../src/components/security/controller/ConfirmController');

describe('Components:Security:Controller:ConfirmController', function () {

  var createController,
      $q,
      $rootScope,
      $state,
      Security;

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      $state = jasmine.createSpyObj('$state', ['go']);
      $state.params = {
        token: 'token'
      };
      Security = jasmine.createSpyObj('Security', ['confirm']);
      var $controller = $injector.get('$controller');
      $q = $injector.get('$q');
      $rootScope = $injector.get('$rootScope');
      createController = function () {
        return $controller(ConfirmController, {'Security': Security, '$state': $state});
      };

    });
  });

  it('should set progress to false and success to true if confirm is successful', function () {

    Security.confirm.and.returnValue($q.when(true));

    var controller = createController();
    expect(controller.success).toBeFalsy();
    expect(controller.inProgress).toBeTruthy();
    $rootScope.$apply();

    expect(controller.inProgress).toBeFalsy();
    expect(controller.success).toBeTruthy();

  });

  it('should set progress to false and success to false if confirm is failed', function () {

    Security.confirm.and.returnValue($q.reject(false));

    var controller = createController();
    expect(controller.success).toBeFalsy();
    expect(controller.inProgress).toBeTruthy();
    $rootScope.$apply();

    expect(controller.inProgress).toBeFalsy();
    expect(controller.success).toBeFalsy();

  });
});