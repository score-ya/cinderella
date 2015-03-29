'use strict';

var User = require('../../../src/shared/service/User');

describe('Shared:Service:User', function () {

  var UserInstance, Cache;

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      Cache = jasmine.createSpyObj('Cache', ['put', 'get', 'removeAll']);
      var CacheFactory = jasmine.createSpy('CacheFactory');
      CacheFactory.and.returnValue(Cache);
      UserInstance = $injector.instantiate(User, {CacheFactory: CacheFactory});
      expect(CacheFactory).toHaveBeenCalledWith('userData', {storageMode: 'sessionStorage'});
    });
  });

  it('should set a token', function () {
    UserInstance.setToken('token');

    expect(Cache.put).toHaveBeenCalledWith('jwt_token', 'token');
  });

  it('should return the token', function () {
    Cache.get.and.returnValue('token');
    expect(UserInstance.getToken()).toBe('token');
    expect(Cache.get).toHaveBeenCalledWith('jwt_token');
  });

  it('should return if the user is logged in or not', function () {
    Cache.get.and.returnValue('token');
    expect(UserInstance.isLoggedIn()).toBeTruthy();
    Cache.get.and.returnValue(undefined);
    expect(UserInstance.isLoggedIn()).toBeFalsy();
    expect(Cache.get).toHaveBeenCalledWith('jwt_token');
  });

  it('should logout an user and remove all from cache', function () {
    UserInstance.logout();

    expect(Cache.removeAll).toHaveBeenCalled();
  });

  it('should set an api key', function () {
    UserInstance.setApiKey('key');

    expect(Cache.put).toHaveBeenCalledWith('api_key', 'key');
  });

  it('should return the api key', function () {
    Cache.get.and.returnValue('key');
    expect(UserInstance.getApiKey()).toBe('key');
    expect(Cache.get).toHaveBeenCalledWith('api_key');
  });

});