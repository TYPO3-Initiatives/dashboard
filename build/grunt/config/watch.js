const path = require('path');

module.exports = function (grunt) {

    const extDirectory = grunt.config.get('extDirectory');
    const svgsToWatch = [];

    return {
        css: {
            files: '<%= sassDirectory %>/**/*.scss',
            tasks: ['sass:dev', 'postcss:dev'],
            options: {
                spawn: false,
                event: 'changed'
            }
        },
        sassImports: {
            files: [
                '<%= sassDirectory %>/Layout/**/!(*_tmp*).scss',
                '<%= sassDirectory %>/Modules/**/!(*_tmp*).scss',
                '<%= sassDirectory %>/Utilities/**/!(*_tmp*).scss'
            ],
            tasks: ['sass_globbing:generate'],
            options: {
                spawn: false,
                event: ['added', 'deleted']
            }
        },
        svg: {
            files: svgsToWatch,
            tasks: ['svgstore'],
            options: {
                spawn: true,
                event: 'all'
            }
        }
    }
};