'use strict';

var MetaController = require('../../../src/shared/meta/MetaController');

describe('Shared:Meta:Controller:MetaController', function () {

  var createController;

  var $state = jasmine.createSpyObj('$state', ['go']);
  var User = jasmine.createSpyObj('User', ['isLoggedIn', 'logout']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      createController = function () {
        return $controller(MetaController, {'User': User, '$state': $state});
      };

    });
  });

  it('should return true if user is logged in', function () {

    var controller = createController();
    User.isLoggedIn.and.returnValue(true);

    expect(controller.isLoggedIn()).toBeTruthy();
  });

  it('should logout an user and redirect to login', function () {

    var controller = createController();

    controller.logout();

    expect(User.logout).toHaveBeenCalled();
    expect($state.go).toHaveBeenCalledWith('security.login');
  });

});