'use strict';

var TemplateService = require('../../../../src/components/template/service/TemplateService');

describe('Components:Template:Service:TemplateService', function() {

  var TemplateServiceInstance;

  beforeEach(function() {
    angular.mock.inject(function($injector){
      TemplateServiceInstance = $injector.instantiate(TemplateService, {});
    });
  });

  it('should return the correct format for a mime type', function() {
    expect(TemplateServiceInstance.getFormat('text/plain')).toEqual('txt');
  });

  it('should return the correct mime type for a format', function() {
    expect(TemplateServiceInstance.getMimeType('html')).toEqual('text/html');
  });

});