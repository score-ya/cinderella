'use strict';

module.exports = {
  template: {
    url: '/templates',
    abstract: true,
    views: {
      'main@': {
        templateUrl: '/views/template/base.html',
        controller: 'TemplateListController as vm'
      }
    },
    resolve: {
      Template: 'Template',

      // Use the resource to fetch data from the server
      templates: function (Template) {
        return Template.query().$promise;
      }
    }
  },
  'template.overview': {
    url: '',
    views: {
      detail: {
        templateUrl: '/views/template/detail.html',
        controller: 'TemplateDetailController as vm'
      },
      'header@': {
        templateUrl: '/views/template/header.html',
        controller: 'TemplateDetailController as vm'
      }
    },
    resolve: {

      $filter: '$filter',

      template: function (templates, $filter) {
        return angular.copy($filter('unique')(templates)[0]);
      }
    }
  },
  'template.detail': {
    url: '/{id:[a-f\\d]{24}}',
    views: {
      detail: {
        templateUrl: '/views/template/detail.html',
        controller: 'TemplateDetailController as vm'
      },
      'header@': {
        templateUrl: '/views/template/header.html',
        controller: 'TemplateDetailController as vm'
      }
    },
    resolve: {

      $filter: '$filter',
      $stateParams: '$stateParams',

      template: function (templates, $stateParams, $filter) {
        return angular.copy($filter('filter')(templates, {
          id: $stateParams.id
        })[0]);
      }
    }
  },
  'template.new': {
    url: '/new',
    views: {
      detail: {
        templateUrl: '/views/template/detail.html',
        controller: 'TemplateDetailController as vm'
      },
      'header@': {
        templateUrl: '/views/template/header.html',
        controller: 'TemplateDetailController as vm'
      }
    },
    resolve: {
      Template: 'Template',

      template: function (Template) {
        return new Template();
      }
    }
  }
};