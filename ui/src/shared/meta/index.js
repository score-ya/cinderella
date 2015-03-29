'use strict';

var angular = require('angular');
var MetaController = require('./MetaController');

module.exports = angular
  .module('meta', [])
  .controller('MetaController', MetaController);
