'use strict';
/**
 * @ngInject
 */
module.exports = function() {

  this.formats = {
    'text/plain' : 'txt',
    'text/html' : 'html'
  };

  this.getFormat = function(mimeType) {
    return this.formats[mimeType];
  };

  this.getMimeType = function(formatToFind) {

    for (var mimeType in this.formats) {

      if (this.formats.hasOwnProperty(mimeType) &&  this.formats[mimeType] === formatToFind) {
        return mimeType;
      }
    }
  };
};
