'use strict';

module.exports = require('angular').module('shared', [require('./meta').name])
  .service('UserService', require('./service/UserService'));
