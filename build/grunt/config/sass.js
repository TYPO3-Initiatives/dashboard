var path = require('path'),
    sass = require('node-sass');

module.exports = function (grunt) {
  var styleParts = grunt.config.get('styleParts'),
    scssFilePaths = [],
    sassTasks = {};

  for (let stylePart in grunt.config.get('styleParts')) {
    if (styleParts.hasOwnProperty(stylePart)) {
      styleParts[stylePart].stylesheets.forEach(function (fileName) {
        // The SCSS-file has a upperCamelCase filename, but for the CSS-file we want a lowerCamelCase filename
        // So take the first char, make it lowercase and keep the rest the same
        var scss = grunt.config.get('sassDirectory') + '/' + fileName + '.scss',
          css = grunt.config.get('cssDirectory') + '/' + (fileName.charAt(0).toLowerCase() + fileName.substr(1)) + '.css';

        styleParts[stylePart].scssFilePaths.push({
          src: scss,
          dest: css
        });
      });

      scssFilePaths = scssFilePaths.concat(styleParts[stylePart].scssFilePaths);

      sassTasks[stylePart] = {
        options: {
          implementation: sass,
          outputStyle: 'nested',
          sourceMap: true
        },
        files: styleParts[stylePart].scssFilePaths
      };
    }
  }

  sassTasks['build'] = {
    options: {
      implementation: sass,
      outputStyle: 'compressed',
      sourceMap: false
    },
    files: scssFilePaths
  };

  return sassTasks;
};
