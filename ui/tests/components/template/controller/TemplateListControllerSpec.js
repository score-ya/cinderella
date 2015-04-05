'use strict';

var TemplateListController = require('../../../../src/components/template/controller/TemplateListController');

describe('Components:Template:Controller:TemplateListController', function () {

  var createController,
    templates,
    TemplateService,
    $state,
    $rootScope;


  beforeEach(function () {
    TemplateService = jasmine.createSpyObj('TemplateService', ['getFormat']);
    $state = jasmine.createSpyObj('$state', ['go']);

    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      $rootScope = $injector.get('$rootScope');
      templates = ['templates'];
      var locals = {
        TemplateService: TemplateService,
        templates: templates,
        $state: $state,
        $rootScope: $rootScope,
        $scope: $rootScope
      };
      createController = function () {
        return $controller(TemplateListController, locals);
      };

    });
  });

  it('should init the templates', function () {

    var controller = createController();
    expect(controller.templates).toEqual(['templates']);
  });

  it('should redirect to new template view if templates are empty', function () {

    templates.pop();

    var controller = createController();
    expect(controller.templates).toEqual([]);
    expect($state.go).toHaveBeenCalledWith('template.new');
  });

  it('should redirect to new template view if templates are empty and route changes to overview', function () {
    createController();
    templates.pop();

    $rootScope.$emit('$stateChangeStart', {name: 'other'});
    expect($state.go).not.toHaveBeenCalled();
    $rootScope.$emit('$stateChangeStart', {name: 'template.overview'});
    expect($state.go).toHaveBeenCalledWith('template.new');
  });

  it('should remove listener if controller is destroyed', function () {
    createController();
    templates.pop();

    $rootScope.$emit('$destroy');
    $rootScope.$emit('$stateChangeStart', {name: 'template.overview'});
    expect($state.go).not.toHaveBeenCalled();
  });

});
