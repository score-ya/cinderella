'use strict';

var TemplateDetailController = require('../../../../src/components/template/controller/TemplateDetailController');

describe('Components:Template:Controller:TemplateDetailController', function () {

  var createController, template, $q, $rootScope;

  var $state = jasmine.createSpyObj('$state', ['reload']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      $q = $injector.get('$q');
      $rootScope = $injector.get('$rootScope');
      createController = function () {
        return $controller(TemplateDetailController, {'$state': $state, template: template});
      };

    });
  });

  it('should update a template', function () {

    template = jasmine.createSpyObj('template', ['$update']);

    template.$update.and.returnValue($q.when(true));

    var controller = createController();

    controller.save();
    $rootScope.$apply();

    expect($state.reload).toHaveBeenCalled();
  });

});