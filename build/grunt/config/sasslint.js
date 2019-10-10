const path = require('path');

module.exports = function (grunt) {
    const files = [];

    grunt.config('extensions')
        .filter(extension => extension.sassLinting === true)
        .forEach(extension => {
            const baseDir = path.join(grunt.config('extDirectory'), extension.name, grunt.config('scssDirectory'));

            files.push({
                src: path.join(baseDir, '**/*.scss')
            })
        });

    return {
        dev: {
            options: {
                configFile: '../../.sass-lint.yml'
            },
            files: files
        },
        build: {
            options: {
                configFile: '../../.sass-lint.yml',
                formatter: 'junit',
                outputFile: '../log/sass-lint.xml'
            },
            files: files
        }
    }
};
