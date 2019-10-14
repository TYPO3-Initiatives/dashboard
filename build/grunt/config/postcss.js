const path = require('path');

module.exports = function (grunt) {
    const files = [],
        processors = [
            require('autoprefixer')({
                cascade: false,
                remove: false
            }),
            require('postcss-pxtorem')({
                rootValue: 10,
                unitPrecision: 5,
                propList: ['*', '!letter-spacing', '!*box*', '!line-height', '!border*', '!background*'],
                selectorBlackList: [],
                replace: true,
                mediaQuery: false,
            })
        ],
        configObject = {
            options: {
                map: true,
                processors: processors
            }
        };

    grunt.config('extensions')
        .filter(extension => extension.cssOutputFile !== '')
        .forEach(extension => {
            const cssFiles = {
                src: path.join(grunt.config('extDirectory'), extension.name, grunt.config('cssDirectory'), extension.cssOutputFile),
                dest: path.join(grunt.config('extDirectory'), extension.name, grunt.config('cssDirectory'), extension.cssOutputFile)
            };

            // Add the src+dest object to the list of all items that should be processed
            files.push(cssFiles);

            // But also create a separate sass task for this extension only, which will be triggered by the watcher
            configObject[extension.name] = {
                files: [cssFiles]
            }
        });

    configObject.dev = {
        files: files
    };

    configObject.build = {
        options: {
            map: false,
            processors: processors
        },
        files: files
    };

    return configObject
};
