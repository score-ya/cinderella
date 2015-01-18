'use strict';

var SecurityService = require('../../../../src/components/security/service/SecurityService');

describe('Components:Security:Service:TemplateService', function () {

  var SecurityServiceInstance, $httpBackend;

  var UserService = jasmine.createSpyObj('UserService', ['setToken']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {

      $httpBackend = $injector.get('$httpBackend');
      $httpBackend.when('POST', '/api/login')
        .respond({token: 'token'});
      SecurityServiceInstance = $injector.instantiate(SecurityService, {UserService: UserService});
    });
  });

  afterEach(function() {
    $httpBackend.verifyNoOutstandingExpectation();
    $httpBackend.verifyNoOutstandingRequest();
  });

  it('should login an user and set the jwt token', function () {


    $httpBackend.expectPOST('/api/login', 'data');

    SecurityServiceInstance.login('data');

    $httpBackend.flush();

    expect(UserService.setToken).toHaveBeenCalledWith('token');
  });

});