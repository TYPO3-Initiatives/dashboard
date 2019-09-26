var path = require('path'),
  sass = require('node-sass');

module.exports = function (grunt) {
  var styleParts = grunt.config.get('styleParts'),
    watchTask = {};

  for (let stylePart in grunt.config.get('styleParts')) {
    if (styleParts.hasOwnProperty(stylePart)) {

      watchTask[stylePart] = {
        files: grunt.config.get('sassDirectory') + '/**/*.scss',
        tasks: ['sass:' + stylePart, 'postcss:' + stylePart, 'bsReload:css'],
        options: {
          spawn: false,
          event: 'changed'
        }
      };
    }
  }

  return watchTask;
};
