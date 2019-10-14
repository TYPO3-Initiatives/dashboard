const path = require('path');

module.exports = function (grunt) {
    const watchItems = {},
        globbingFiles = [];

    grunt.config('extensions').forEach(extension => {
        const baseDir = path.join(grunt.config('extDirectory'), extension.name, grunt.config('scssDirectory'));

        if (extension.globbingFolderNames.length > 0) {
            extension.globbingFolderNames.forEach(folderToGlob => {
                globbingFiles.push(path.join(baseDir, folderToGlob, grunt.config('globPattern')))
            })
        }

        if (extension.sassFile !== '') {
            // Note that each extension has it's own watcher which triggers a extension specific sass + postcss task
            // Without this, every little change would generate 11 CSS-files to be generated + processed by postcss.
            watchItems['sass-dev'] = {
                files: path.join(baseDir, '**/*.scss'),
                tasks: ['sass:dev', 'postcss:dev'],
                options: {
                    spawn: false,
                    event: 'changed'
                }
            }
        }
    });

    if (globbingFiles.length > 0) {
        watchItems.sassImports = {
            files: globbingFiles,
            tasks: ['sass_globbing:generate'],
            options: {
                spawn: false,
                event: ['added', 'deleted']
            }
        }
    }

    return watchItems
};
