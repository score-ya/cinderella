'use strict';

var TemplateDetailController = require('../../../../src/components/template/controller/TemplateDetailController');

describe('Components:Template:Controller:TemplateDetailController', function () {

  var createController,
      template,
      $q,
      $rootScope,
      $state,
      $modal;

  beforeEach(function () {
    $state = jasmine.createSpyObj('$state', ['reload', 'go']);
    $modal = jasmine.createSpyObj('$modal', ['open']);
    angular.mock.inject(function ($injector) {
      template = jasmine.createSpyObj('template', ['$update', '$delete', '$save']);
      var $controller = $injector.get('$controller');
      $q = $injector.get('$q');
      $rootScope = $injector.get('$rootScope');
      createController = function () {
        return $controller(TemplateDetailController, {'$state': $state, template: template, $modal: $modal});
      };

    });
  });

  it('should update a template', function () {

    template.id = 'id';

    template.$update.and.returnValue($q.when(true));

    var controller = createController();

    controller.save();
    $rootScope.$apply();

    expect($state.reload).toHaveBeenCalled();
  });

  it('should save a new template', function () {

    template.$save.and.returnValue($q.when('id'));

    var controller = createController();

    controller.save();
    $rootScope.$apply();

    expect($state.go).toHaveBeenCalledWith('template.detail', { id: 'id' }, { reload: true });
  });

  it('should copy a template', function () {

    template.$save.and.returnValue($q.when(true));

    var controller = createController();

    controller.copy();
    $rootScope.$apply();

    expect($state.reload).toHaveBeenCalled();
  });

  it('should delete a template', function () {

    template.$delete.and.returnValue($q.when(true));

    var controller = createController();

    controller.delete();
    $rootScope.$apply();

    expect($state.go).toHaveBeenCalledWith('template.overview', {}, {reload: true});
  });

  it('should open a modal for the template url', function () {

    var controller = createController();

    controller.showTemplateUrl();
    var call = {
      templateUrl: '/views/template/template_url.html',
      controller: 'TemplateUrlController as vm',
      resolve: {
        template: jasmine.any(Function)
      }
    };
    expect($modal.open).toHaveBeenCalledWith(call);
    expect($modal.open.calls.argsFor(0)[0].resolve.template()).toEqual(template);
  });

});