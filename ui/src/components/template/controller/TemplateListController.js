'use strict';

/**
 * @ngInject
 */
function TemplateListController(templates, $state, $rootScope, $scope) {
  this.templates = templates;
  if (templates.length === 0) {
    $state.go('template.new');
  }

  var destroyListener = $rootScope.$on('$stateChangeStart', function (e, to) {
    if (to.name === 'template.overview' && templates.length === 0) {
      e.preventDefault();
      $state.go('template.new');
    }
  });

  $scope.$on('$destroy', destroyListener);

}

module.exports = TemplateListController;
