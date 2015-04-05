'use strict';

var RouteChecker = require('../../../../src/components/security/service/RouteChecker');

describe('Components:Security:Service:RouteChecker', function () {

  var RouteCheckerInstance,
      User,
      $state,
      $rootScope;

  beforeEach(function () {
    User = jasmine.createSpyObj('User', ['isLoggedIn']);
    $state = jasmine.createSpyObj('$state', ['go']);
    angular.mock.inject(function ($injector) {
      $rootScope = $injector.get('$rootScope');
      RouteCheckerInstance = $injector.instantiate(RouteChecker, {User: User, $state: $state});
    });
  });

  it('should redirect to login if state with authentication is called and user is not authenticated ', function () {
    User.isLoggedIn.and.returnValue(false);

    $rootScope.$emit('$stateChangeStart', {params: {auth: true}});

    expect($state.go).toHaveBeenCalledWith('security.login');

  });

  it('should redirect to template overview if security state is called and user is authenticated ', function () {
    User.isLoggedIn.and.returnValue(true);

    $rootScope.$emit('$stateChangeStart', {params: {auth: false}});

    expect($state.go).toHaveBeenCalledWith('template.overview');

  });

});