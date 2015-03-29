'use strict';

var TemplateListController = require('../../../../src/components/template/controller/TemplateListController');

describe('Components:Template:Controller:TemplateListController', function () {

  var createController, templates;

  var TemplateService = jasmine.createSpyObj('TemplateService', ['getFormat']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      createController = function () {
        return $controller(TemplateListController, {'TemplateService': TemplateService, templates: templates});
      };

    });
  });

  it('should init the templates', function () {

    templates = 'templates';

    var controller = createController();
    expect(controller.templates).toBe('templates');
  });

});