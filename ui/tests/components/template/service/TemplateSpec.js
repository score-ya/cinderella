'use strict';

var Template = require('../../../../src/components/template/service/Template');

describe('Components:Template:Service:Template', function () {

  var TemplateInstance,
    User = jasmine.createSpyObj('User', ['getApiKey']),
    $location = jasmine.createSpyObj('$location', ['host', 'protocol']),
    $resource = jasmine.createSpy('$resource');

  $resource.and.returnValue({});

  beforeEach(function () {
    angular.mock.inject(function ($injector) {
      TemplateInstance = $injector.instantiate(Template, {User: User, $location: $location, $resource: $resource});
    });
  });

  it('should init the resource', function () {
    expect($resource).toHaveBeenCalledWith('/api/templates/:id', {id: '@id'}, {
      update: {method: 'PUT'},
      save: {method: 'POST', interceptor: {response: jasmine.any(Function)}}
    });
  });

  it('should return the id of a location', function () {
    var response = jasmine.createSpyObj('response', ['headers']);

    response.headers.and.returnValue('/uri/id');

    expect($resource.calls.argsFor(0)[2].save.interceptor.response(response)).toBe('id');
  });

  it('should return the correct format for a mime type', function () {
    expect(TemplateInstance.getFormat('text/plain')).toEqual('txt');
  });

  it('should return the api url for the template with api key', function () {

    $location.protocol.and.returnValue('http');
    $location.host.and.returnValue('host');
    User.getApiKey.and.returnValue('key');

    expect(TemplateInstance.getUrl({
      name: 'template',
      mimeType: 'text/plain'
    })).toEqual('http://host/api/template/template.txt?apikey=key');
  });

  it('should return the api url for the template with api key and defined base url', function () {

    $location.protocol.and.returnValue('http');
    $location.host.and.returnValue('host');
    User.getApiKey.and.returnValue('key');

    process.env.BASE_TEMPLATE_URL = 'otherUri';

    expect(TemplateInstance.getUrl({
      name: 'template',
      mimeType: 'text/plain'
    })).toEqual('otherUri/api/template/template.txt?apikey=key');
  });

});