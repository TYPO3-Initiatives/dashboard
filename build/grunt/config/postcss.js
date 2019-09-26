var path = require('path'),
  sass = require('node-sass');

module.exports = function (grunt) {
  var styleParts = grunt.config.get('styleParts'),
    cssFilePaths = [],
    postCssTasks = {};

  for (let stylePart in grunt.config.get('styleParts')) {
    if (styleParts.hasOwnProperty(stylePart)) {
      styleParts[stylePart].stylesheets.forEach(function (fileName) {
        // The SCSS-file has a upperCamelCase filename, but for the CSS-file we want a lowerCamelCase filename
        // So take the first char, make it lowercase and keep the rest the same
        var css = grunt.config.get('cssDirectory') + '/' + (fileName.charAt(0).toLowerCase() + fileName.substr(1)) + '.css';

        styleParts[stylePart].cssFilePaths.push({
          src: css,
          dest: css
        });
      });

      cssFilePaths = cssFilePaths.concat(styleParts[stylePart].cssFilePaths);

      postCssTasks[stylePart] = {
        options: {
          map: true,
          processors: [
            require('autoprefixer')({
              browsers: ['> 1%', 'last 2 versions', 'firefox 24', 'opera 12.1', 'IE 8'],
              cascade: false,
              remove: false
            })
          ]
        },
        files: styleParts[stylePart].cssFilePaths
      };
    }
  }

  postCssTasks['build'] = {
    options: {
      map: false,
      processors: [
        require('autoprefixer')({
          browsers: ['> 1%', 'last 2 versions', 'firefox 24', 'opera 12.1', 'IE 8'],
          cascade: false,
          remove: false
        })
      ]
    },
    files: cssFilePaths
  };

  return postCssTasks;
};
