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
        projectDirectory = extDirectory;

    require('jit-grunt')(grunt, {
        sasslint: 'grunt-sass-lint'
    });

    var config = {
        pkg: grunt.file.readJSON('package.json'),
        extDirectory: extDirectory,
        projectDirectory: projectDirectory,
        sassDirectory: path.join(projectDirectory, 'Resources/Private/Styles'),
        cssDirectory: path.join(projectDirectory, 'Resources/public/CSS'),
        scssFileName: 'Dashboard.scss',
        cssFileName: 'Dashboard.css',
        cssJsonFiles: grunt.file.expand([path.join(projectDirectory, 'css-bundle.dashboard.json')]),

    };

    console.log(projectDirectory);
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

    grunt.registerTask('default', ['sass_globbing:generate', 'sass:dev', 'postcss:dev', 'watch']);
    grunt.registerTask('lint', ['sasslint:dev']);
    grunt.registerTask('build', ['sasslint:build', 'sass_globbing:generate', 'sass:build', 'postcss:build', 'cssmin:build']);
};
