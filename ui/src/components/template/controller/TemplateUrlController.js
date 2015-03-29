'use strict';

/**
 * @ngInject
 */
function TemplateUrlController(template, $modalInstance, Template) {
  var vm = this;

  vm.close = close;
  vm.url = Template.getUrl(template);

  function close() {
    $modalInstance.dismiss();
  }
}

module.exports = TemplateUrlController;
