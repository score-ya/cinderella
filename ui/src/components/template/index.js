'use strict';

var angular = require('angular');
var RoutingConfig = require('./config');

module.exports = angular.module('template', []);

angular.module('template').controller("TemplateListController", require('./controller/TemplateListController'));
angular.module('template').controller("TemplateDetailController", require('./controller/TemplateDetailController'));
angular.module('template').service("TemplateService", require('./service/TemplateService'));
angular.module('template').factory("Template", function ($resource) {
  return $resource("/api/templates/:id", {id: "@id"}, {'update': {method: 'PUT'}});
});
angular.module('template').config(function ($stateProvider, $translatePartialLoaderProvider) {
  angular.forEach(RoutingConfig, function (config, name) {
    $stateProvider.state(name, config)
  });
  $translatePartialLoaderProvider.addPart('template');
});
