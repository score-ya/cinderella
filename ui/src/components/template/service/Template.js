'use strict';
/**
 * @ngInject
 */
function Template(User, $location, $resource) {

  var formats = {
    'text/plain': 'txt',
    'text/html': 'html'
  };

  var Service = $resource('/api/templates/:id', {id: '@id'}, {
    update: {method: 'PUT'},
    save: {
      method: 'POST',
      interceptor: {
        response: function (response) {
          return response.headers('location').split('/').pop();
        }
      }
    }
  });

  Service.getFormat = getFormat;
  Service.getUrl = getUrl;

  return Service;
  ////////////

  function getFormat(mimeType) {
    return formats[mimeType];
  }

  function getUrl(template) {
    var baseTemplateUrl = $location.protocol() + '://' + $location.host();

    if (process.env.BASE_TEMPLATE_URL) {
      baseTemplateUrl = process.env.BASE_TEMPLATE_URL;
    }

    return baseTemplateUrl + '/api/template/' + template.apiName + '.' + getFormat(template.mimeType) + '?apikey=' + User.getApiKey();
  }

}

module.exports = Template;
