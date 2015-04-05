'use strict';

var Security = require('../../../../src/components/security/service/Security');

describe('Components:Security:Service:Security', function () {

  var SecurityInstance,
      $httpBackend,
      User;

  beforeEach(function () {
    User = jasmine.createSpyObj('User', ['setToken', 'setApiKey']);
    angular.mock.inject(function ($injector) {

      $httpBackend = $injector.get('$httpBackend');
      $httpBackend.when('POST', '/api/register').respond({});
      $httpBackend.when('PATCH', '/api/confirm/token').respond({});
      $httpBackend.when('POST', '/api/login')
        .respond({token: 'token', data: {apiKey: 'apiKey'}});
      SecurityInstance = $injector.instantiate(Security, {User: User});
    });
  });

  afterEach(function() {
    $httpBackend.verifyNoOutstandingExpectation();
    $httpBackend.verifyNoOutstandingRequest();
  });

  it('should login an user and set the jwt token', function () {


    $httpBackend.expectPOST('/api/login', 'data');

    SecurityInstance.login('data');

    $httpBackend.flush();

    expect(User.setToken).toHaveBeenCalledWith('token');
    expect(User.setApiKey).toHaveBeenCalledWith('apiKey');
  });

  it('should confirm an user', function () {


    $httpBackend.expectPATCH('/api/confirm/token');

    SecurityInstance.confirm('token');

    $httpBackend.flush();
  });

  it('should register a new user', function () {
    $httpBackend.expectPOST('/api/register', 'data');

    SecurityInstance.register('data');

    $httpBackend.flush();
  });

});