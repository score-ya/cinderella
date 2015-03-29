'use strict';

var TemplateUrlController = require('../../../../src/components/template/controller/TemplateUrlController');

describe('Components:Template:Controller:TemplateUrlController', function () {

  var createController,
      template,
      Template = jasmine.createSpyObj('Template', ['getUrl']),
      $modalInstance = jasmine.createSpyObj('$modalInstance', ['dismiss']);

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      var $controller = $injector.get('$controller');
      createController = function () {
        return $controller(TemplateUrlController, {'Template': Template, template: template, '$modalInstance': $modalInstance});
      };

    });
  });

  it('should init the url', function () {
    Template.getUrl.and.returnValue('url');

    var controller = createController();
    expect(controller.url).toBe('url');
    expect(Template.getUrl).toHaveBeenCalledWith(template);
  });

  it('should close the modal', function () {
    var controller = createController();
    controller.close();
    expect($modalInstance.dismiss).toHaveBeenCalled();
  });

});