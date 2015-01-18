'use strict';

var MetaController = require('../../../src/shared/meta/MetaController');

describe('Shared:Meta:Controller:MetaController', function() {

  var createController;

  var $state = jasmine.createSpyObj('$state', ['go']);
  var UserService = jasmine.createSpyObj('UserService', ['isLoggedIn', 'logout']);

  beforeEach(function() {
    angular.mock.inject(function($injector){
      var $controller = $injector.get('$controller');
      createController = function() {
        return $controller(MetaController, {'UserService' : UserService, '$state': $state});
      };

    });
  });

  it('should return true if user is logged in', function() {

    var controller = createController();
    UserService.isLoggedIn.and.returnValue(true);

    expect(controller.isLoggedIn()).toBeTruthy();
  });

  it('should logout an user and redirect to login', function() {

    var controller = createController();

    controller.logout();

    expect(UserService.logout).toHaveBeenCalled();
    expect($state.go).toHaveBeenCalledWith('security.login');
  });

});