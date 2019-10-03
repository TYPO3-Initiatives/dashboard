/*global module, require, process, console */

// USAGE
// Install the latest LTS version of node
// `npm install` in this folder
// Create an environment variable 'HTTPS_KEY', which points to server.key
// Create an environment variable 'HTTPS_CERT', which points to server.crt
// Start the default task with `grunt`, or set a custom project url with `grunt --url=https://example.org`
module.exports = function (grunt) {
    var fs = require('fs'),
        path = require('path'),
        url = require('url'),
        extDirectory = path.normalize('../..'),
        projectDirectory = extDirectory,
        cssFilePaths = [];

    require('jit-grunt')(grunt, {
        sasslint: 'grunt-sass-lint'
    });

    var config = {
        pkg: grunt.file.readJSON('package.json'),
        extDirectory: extDirectory,
        projectDirectory: projectDirectory,
        sassDirectory: path.join(projectDirectory, 'Resources/Private/Styles'),
        cssDirectory: path.join(projectDirectory, 'Resources/Public/CSS'),
        styleParts: {
            'dashboard': {
                stylesheets: ['Dashboard'],
                scssFilePaths: [],
                cssFilePaths: []
            },
            'numberWidget': {
                stylesheets: ['NumberWidget'],
                scssFilePaths: [],
                cssFilePaths: []
            },
            'rssWidget': {
                stylesheets: ['RssWidget'],
                scssFilePaths: [],
                cssFilePaths: []
            },
        },
        cssJsonFiles: grunt.file.expand([path.join(projectDirectory, 'css-bundle.*.json')]),
        scssFilePaths: [],
    };

    for (var stylePart in config.styleParts) {
        if (config.styleParts.hasOwnProperty(stylePart)) {
            config.styleParts[stylePart].stylesheets.forEach(function (fileName) {
                // The SCSS-file has a upperCamelCase filename, but for the CSS-file we want a lowerCamelCase filename
                // So take the first char, make it lowercase and keep the rest the same
                var css = config.cssDirectory + '/' + (fileName.charAt(0).toLowerCase() + fileName.substr(1)) + '.css';

                config.styleParts[stylePart].cssFilePaths.push({
                    src: css,
                    dest: css
                });
            });

            cssFilePaths = cssFilePaths.concat(config.styleParts[stylePart].cssFilePaths);
        }
    }

    grunt.initConfig(config);

    // Autoload all config files
    fs.readdirSync('./config/').forEach(function (file) {
        var moduleConfig = require('./config/' + file);

        if (typeof moduleConfig === 'function') {
            grunt.config.set(path.parse(file).name, moduleConfig(grunt));
        } else {
            grunt.config.set(path.parse(file).name, moduleConfig);
        }
    });

    for (var stylePart in config.styleParts) {
        grunt.registerTask(stylePart, ['browserSync:' + stylePart, 'sass_globbing:generate', 'sass:' + stylePart, 'postcss:' + stylePart, 'watch:' + stylePart]);
    }
    grunt.registerTask('lint', ['sasslint:dev']);
    grunt.registerTask('build', ['sasslint:build', 'sass_globbing:generate', 'sass:build', 'postcss:build', 'cssmin:build']);
};
