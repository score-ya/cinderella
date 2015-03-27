'use strict';

var angular = require('angular');
var metaModule = require('./meta');
var User = require('./service/User');

module.exports = angular
  .module('shared', [metaModule.name])
  .factory('User', User);
