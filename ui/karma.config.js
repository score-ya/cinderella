'use strict';

module.exports = function(karma) {
  karma.set({

    frameworks: [ 'jasmine', 'browserify' ],

    files: [
      'tests/**/*Spec.js',
      'tests/base.js',
      'src/**/*.js'
    ],
    exclude: [
      'src/**/config.js',
      'src/**/index.js',
      'src/**/app.js'
    ],

    reporters: ['progress', 'coverage'],
    coverageReporter: {
      type : 'html',
      dir : 'coverage/'
    },
    preprocessors: {
      'tests/**/*Spec.js': [ 'browserify' ],
      'tests/base.js': [ 'browserify'],
      'src/**/*.js': [ 'browserify' ]
    },

    browsers: [ 'PhantomJS' ],

    logLevel: 'LOG_INFO',

    singleRun: false,
    autoWatch: true,

    // browserify configuration
    browserify: {
      debug: true,
      transform: ['browserify-shim', 'browserify-ngannotate', 'browserify-istanbul']
    }
  });
};