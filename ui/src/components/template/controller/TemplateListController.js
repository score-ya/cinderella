'use strict';
/**
 * @ngInject
 */
module.exports = function (templates, TemplateService) {
  var vm = this;

  vm.templates =  templates;

  vm.getFormat = function(mimeType) {
    return TemplateService.getFormat(mimeType);
  }
};
