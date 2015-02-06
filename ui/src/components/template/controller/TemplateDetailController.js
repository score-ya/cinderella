'use strict';
/**
 * @ngInject
 */
module.exports = function (template, $state) {
  var vm = this;
  vm.mimeTypes = ['text/html', 'text/plain'];
  vm.template =  template;
  this.save = function() {

    if (template.id) {

      template.$update().then(function () {
        $state.reload();
      });
    }

    if (template.id == undefined) {
      template.$save().then(function () {
        $state.reload();
      });
    }
  };

  this.copy = function() {
    var templateCopy = angular.copy(template);
    delete templateCopy.id;
    templateCopy.name += '_copy';
    templateCopy.$save().then(function(){
      $state.reload();
    });
  };

  this['delete'] = function() {
    template.$delete().then(function(){
      $state.go('template.overview', {}, {reload: true});
    });
  };
};
