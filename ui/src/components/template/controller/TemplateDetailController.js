'use strict';

var angular = require('angular');
/**
 * @ngInject
 */
function TemplateDetailController(template, $state, $modal) {
  var vm = this;

  vm.mimeTypes = ['text/html', 'text/plain'];
  vm.template = template;
  vm.save = save;
  vm.delete = $delete;
  vm.showTemplateUrl = showTemplateUrl;
  vm.copy = copy;

  function save() {
    if (vm.template.id) {
      vm.template.$update().then(function () {
        $state.reload();
      });
    }

    if (vm.template.id === undefined) {
      vm.template.$save().then(function (id) {
        $state.go('template.detail', {id: id}, {reload: true});
      });
    }
  }

  function $delete() {
    vm.template.$delete().then(function () {
      $state.go('template.overview', {}, {reload: true});
    });
  }

  function showTemplateUrl() {
    $modal.open({
      templateUrl: '/views/template/template_url.html',
      controller: 'TemplateUrlController as vm',
      resolve: {
        template: function () {
          return vm.template;
        }
      }
    });
  }

  function copy() {
    var templateCopy = angular.copy(vm.template);
    delete templateCopy.id;
    templateCopy.name += '_copy';
    templateCopy.$save().then(function () {
      $state.reload();
    });
  }
}

module.exports = TemplateDetailController;
