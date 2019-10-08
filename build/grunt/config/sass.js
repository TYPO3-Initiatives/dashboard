const path = require('path'),
    sass = require('node-sass');

module.exports = function (grunt) {
    const configObject = {},
        files = [],
        devOptions = {
            implementation: sass,
            outputStyle: 'nested',
            sourceMap: true
        };

    grunt.config('extensions')
        .filter(extension => extension.sassFile !== '' && extension.cssOutputFile !== '')
        .forEach(extension => {
            const extFiles = {
                src: path.join(grunt.config('extDirectory'), extension.name, grunt.config('scssDirectory'), extension.sassFile),
                dest: path.join(grunt.config('extDirectory'), extension.name, grunt.config('cssDirectory'), extension.cssOutputFile)
            };

            // Add the src+dest object to the list of all items that should be processed
            files.push(extFiles);

            // But also create a separate sass task for this extension only, which will be triggered by the watcher
            configObject[extension.name] = {
                options: devOptions,
                files: [extFiles]
            }
        });

    configObject.dev = {
        options: devOptions,
        files: files
    };

    configObject.build = {
        options: {
            implementation: sass,
            outputStyle: 'compressed',
            sourceMap: false
        },
        files: files
    };

    return configObject
};
