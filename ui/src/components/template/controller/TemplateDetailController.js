'use strict';
/**
 * @ngInject
 */
module.exports = function (template, $state) {
  var vm = this;

  vm.template =  template;
  this.save = function() {
    template.$update().then(function(){
      $state.reload();
    });
  };
};
