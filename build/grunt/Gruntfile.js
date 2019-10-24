module.exports = function (grunt) {
    const fs = require('fs'),
        path = require('path'),
        url = require('url'),
        extDirectory = path.normalize('../../../');

    require('jit-grunt')(grunt, {
        sasslint: 'grunt-sass-lint'
    });

    const config = {
        pkg: grunt.file.readJSON('package.json'),
        extDirectory: extDirectory,
        scssDirectory: 'Resources/Private/Styles',
        cssDirectory: 'Resources/Public/CSS',
        globPattern: '**/!(*_tmp*).scss'
    };

    /**
     * The `defaultExtConfig` object contains all possible keys to configure an extension. All those settings can be
     * overridden with Object.assign(). When a setting is not overriden, the default value will be used.
     * For example see the `sassLinting` item, which is true by default. For some extensions this config item is
     * overriden by false, since those extensions aren't lint valid.
     *
     * @namespace
     * @property {string} name - The name of the extension (same as the folder name in typo3conf/ext/)
     * @property {string} sassFile - Name of the main sass file for the extension (usually Style.scss)
     * @property {string} cssOutputFile - Name of the file where the CSS has to be exported to (usually Style.min.css)
     * @property {array} globbingFolderNames - Array of folder names that are used in sass globbing
     * @property {boolean} sassLinting - Indicates whether the SCSS-files should be linted by sasslint
     */
    var defaultExtConfig = {
        name: 'dashboard',
        sassFile: 'Style.scss',
        cssOutputFile: 'style.min.css',
        globbingFolderNames: [],
        sassLinting: true
    };

    // The list of sass files that is used in the grunt tasks
    // Each sass file has to extend the defaultExtConfig with own config (since the name is required)
    config.extensions = [
        Object.assign({}, defaultExtConfig, {
            sassFile: 'Dashboard.scss',
            cssOutputFile: 'dashboard.min.css',
            globbingFolderNames: ['Base', 'Utilities'],
        }),
        Object.assign({}, defaultExtConfig, {
            sassFile: 'NumberWidget.scss',
            cssOutputFile: 'numberWidget.min.css',
        }),
        Object.assign({}, defaultExtConfig, {
            sassFile: 'DoughnutChartWidget.scss',
            cssOutputFile: 'doughnutChartWidget.min.css',
        }),
        Object.assign({}, defaultExtConfig, {
            sassFile: 'RssWidget.scss',
            cssOutputFile: 'rssWidget.min.css',
        }),
        Object.assign({}, defaultExtConfig, {
            sassFile: 'CtaWidget.scss',
            cssOutputFile: 'ctaWidget.min.css',
        }),
        Object.assign({}, defaultExtConfig, {
            sassFile: 'Modal.scss',
            cssOutputFile: 'Modal/style.css',
            globbingFolderNames: ['Modal'],
        })
    ];

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
