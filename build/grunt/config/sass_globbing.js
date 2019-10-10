const path = require('path');

module.exports = function (grunt) {
    const files = [];

    grunt.config('extensions')
        .filter(extension => extension.globbingFolderNames.length > 0)
        .forEach(extension => {
            const baseDir = path.join(grunt.config('extDirectory'), extension.name, grunt.config('scssDirectory'));

            extension.globbingFolderNames.forEach(folderToGlob => {
                files.push({
                    src: path.join(baseDir, folderToGlob, grunt.config('globPattern')),
                    dest: path.join(baseDir, '_temp_' + folderToGlob.toLowerCase() + '.scss')
                })
            })
        });

    return {
        generate: {
            files: files,
            options: {
                useSingleQuotes: false,
                signature: false
            }
        }
    }
};
